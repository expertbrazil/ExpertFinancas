class AlertManager {
    constructor() {
        this.init();
    }

    init() {
        // Process flash messages on page load
        document.addEventListener('DOMContentLoaded', () => {
            const flashMessages = document.querySelectorAll('[data-flash-message]');
            flashMessages.forEach(element => {
                const message = element.getAttribute('data-flash-message');
                const type = element.getAttribute('data-flash-type');
                this.show(message, type);
                element.remove();
            });
        });
    }

    show(message, type = 'info', duration = 5000) {
        // Create alert container if it doesn't exist
        let alertContainer = document.querySelector('.alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.className = 'alert-container';
            document.body.appendChild(alertContainer);

            // Add styles
            const style = document.createElement('style');
            style.textContent = `
                .alert-container {
                    position: fixed;
                    top: 1rem;
                    right: 1rem;
                    z-index: 9999;
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                    max-width: 24rem;
                }

                .alert-item {
                    padding: 1rem;
                    border-radius: 0.375rem;
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                    display: flex;
                    align-items: flex-start;
                    gap: 0.75rem;
                    transform: translateX(100%);
                    opacity: 0;
                    transition: all 0.3s ease-in-out;
                }

                .alert-item.show {
                    transform: translateX(0);
                    opacity: 1;
                }

                .alert-icon {
                    flex-shrink: 0;
                    width: 1.25rem;
                    height: 1.25rem;
                }

                .alert-content {
                    flex-grow: 1;
                    font-size: 0.875rem;
                    line-height: 1.25rem;
                }

                .alert-close {
                    flex-shrink: 0;
                    width: 1.25rem;
                    height: 1.25rem;
                    cursor: pointer;
                    opacity: 0.5;
                    transition: opacity 0.2s;
                }

                .alert-close:hover {
                    opacity: 1;
                }
            `;
            document.head.appendChild(style);
        }

        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert-item alert-${type}`;
        
        // Set background and icon based on type
        let backgroundColor, iconSvg;
        switch(type) {
            case 'success':
                backgroundColor = '#ecfdf5';
                iconSvg = '<svg class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                break;
            case 'error':
                backgroundColor = '#fef2f2';
                iconSvg = '<svg class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                break;
            case 'warning':
                backgroundColor = '#fffbeb';
                iconSvg = '<svg class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
                break;
            default: // info
                backgroundColor = '#eff6ff';
                iconSvg = '<svg class="alert-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
        }
        
        alert.style.backgroundColor = backgroundColor;
        
        // Set alert content
        alert.innerHTML = `
            ${iconSvg}
            <div class="alert-content">${message}</div>
            <svg class="alert-close" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        `;

        // Add close functionality
        const closeButton = alert.querySelector('.alert-close');
        closeButton.addEventListener('click', () => this.dismiss(alert));

        // Add to container
        alertContainer.appendChild(alert);

        // Trigger animation
        setTimeout(() => alert.classList.add('show'), 10);

        // Auto dismiss
        if (duration > 0) {
            setTimeout(() => this.dismiss(alert), duration);
        }
    }

    dismiss(alert) {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 300);
    }
}

// Initialize alert manager
window.alerts = new AlertManager();
