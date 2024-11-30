<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;

trait NotificationTrait
{
    /**
     * Envia uma notificação por e-mail
     *
     * @param string $to Endereço de e-mail do destinatário
     * @param string $subject Assunto do e-mail
     * @param string $message Mensagem do e-mail
     * @param array $data Dados adicionais para o template
     * @return bool
     */
    protected function sendEmailNotification(string $to, string $subject, string $message, array $data = []): bool
    {
        try {
            Mail::send([], [], function ($mail) use ($to, $subject, $message) {
                $mail->to($to)
                    ->subject($subject)
                    ->html($message);
            });

            Log::info("E-mail enviado para {$to}", [
                'subject' => $subject,
                'data' => $data
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Erro ao enviar e-mail para {$to}", [
                'error' => $e->getMessage(),
                'subject' => $subject,
                'data' => $data
            ]);

            return false;
        }
    }

    /**
     * Envia uma notificação para vários canais
     *
     * @param mixed $notifiable Modelo que receberá a notificação
     * @param string $title Título da notificação
     * @param string $message Mensagem da notificação
     * @param array $channels Canais de notificação (mail, database, etc)
     * @return void
     */
    protected function sendMultiChannelNotification($notifiable, string $title, string $message, array $channels = ['mail', 'database']): void
    {
        Notification::send($notifiable, new class($title, $message, $channels) {
            private $title;
            private $message;
            private $channels;

            public function __construct($title, $message, $channels)
            {
                $this->title = $title;
                $this->message = $message;
                $this->channels = $channels;
            }

            public function via($notifiable)
            {
                return $this->channels;
            }

            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject($this->title)
                    ->line($this->message);
            }

            public function toDatabase($notifiable)
            {
                return [
                    'title' => $this->title,
                    'message' => $this->message,
                    'notifiable_type' => get_class($notifiable),
                    'notifiable_id' => $notifiable->id
                ];
            }
        });
    }

    /**
     * Envia uma notificação de alerta
     *
     * @param string $type Tipo do alerta (success, error, warning, info)
     * @param string $message Mensagem do alerta
     * @param array $data Dados adicionais
     * @return void
     */
    protected function sendAlert(string $type, string $message, array $data = []): void
    {
        $alert = [
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'timestamp' => now()
        ];

        // Log do alerta
        Log::channel('alerts')->info("Alerta enviado", $alert);

        // Aqui você pode adicionar lógica adicional como:
        // - Salvar no banco de dados
        // - Enviar para um serviço de monitoramento
        // - Notificar administradores
        // etc.
    }

    /**
     * Envia uma notificação de vencimento
     *
     * @param mixed $model Modelo relacionado ao vencimento
     * @param int $diasAntecedencia Dias de antecedência para notificar
     * @return void
     */
    protected function sendVencimentoNotification($model, int $diasAntecedencia = 5): void
    {
        $dataVencimento = $model->data_vencimento ?? null;
        
        if (!$dataVencimento) {
            return;
        }

        $diasRestantes = now()->diffInDays($dataVencimento, false);
        
        if ($diasRestantes <= $diasAntecedencia && $diasRestantes >= 0) {
            $this->sendMultiChannelNotification(
                $model->responsavel ?? $model->cliente ?? $model->user,
                "Aviso de Vencimento",
                "Você tem um {$model->tipo} vencendo em {$diasRestantes} dias.",
                ['mail', 'database']
            );
        }
    }
}
