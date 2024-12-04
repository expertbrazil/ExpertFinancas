<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class TechnicalHelpController extends Controller
{
    protected $converter;

    public function __construct()
    {
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function index()
    {
        $topics = $this->getAllTopics();
        return view('technical-help.index', compact('topics'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $topics = $this->searchTopics($query);
        return view('technical-help.search', compact('topics', 'query'));
    }

    public function show($topic)
    {
        $content = $this->getTopicContent($topic);
        $relatedTopics = $this->getRelatedTopics($topic);
        return view('technical-help.show', compact('content', 'topic', 'relatedTopics'));
    }

    public function diagram()
    {
        return view('technical-help.diagram');
    }

    protected function getAllTopics()
    {
        $topics = [];
        $docsPath = base_path('docs');
        
        if (File::exists($docsPath)) {
            $files = File::files($docsPath);
            
            foreach ($files as $file) {
                if ($file->getExtension() === 'md') {
                    $content = File::get($file->getPathname());
                    $title = $this->extractTitle($content);
                    $summary = $this->extractSummary($content);
                    
                    $topics[] = [
                        'slug' => Str::slug($file->getFilenameWithoutExtension()),
                        'title' => $title,
                        'summary' => $summary,
                        'path' => $file->getPathname(),
                        'updated_at' => File::lastModified($file->getPathname()),
                    ];
                }
            }
        }

        return collect($topics)->sortBy('title');
    }

    protected function searchTopics($query)
    {
        return $this->getAllTopics()
            ->filter(function ($topic) use ($query) {
                return Str::contains(strtolower($topic['title']), strtolower($query)) ||
                       Str::contains(strtolower($topic['summary']), strtolower($query));
            });
    }

    protected function getTopicContent($topic)
    {
        $path = base_path("docs/{$topic}.md");
        
        if (!File::exists($path)) {
            abort(404);
        }

        $markdown = File::get($path);
        return [
            'html' => $this->converter->convert($markdown)->getContent(),
            'title' => $this->extractTitle($markdown),
            'updated_at' => File::lastModified($path),
        ];
    }

    protected function getRelatedTopics($currentTopic)
    {
        return $this->getAllTopics()
            ->filter(function ($topic) use ($currentTopic) {
                return $topic['slug'] !== $currentTopic;
            })
            ->take(3);
    }

    protected function extractTitle($content)
    {
        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            if (preg_match('/^#\s+(.+)$/', $line, $matches)) {
                return trim($matches[1]);
            }
        }
        return 'Sem título';
    }

    protected function extractSummary($content)
    {
        $lines = explode("\n", $content);
        $summary = '';
        $foundTitle = false;

        foreach ($lines as $line) {
            if (!$foundTitle && strpos($line, '#') === 0) {
                $foundTitle = true;
                continue;
            }

            if ($foundTitle && trim($line) && strpos($line, '#') !== 0) {
                $summary = trim($line);
                break;
            }
        }

        return Str::limit($summary, 150);
    }
}
