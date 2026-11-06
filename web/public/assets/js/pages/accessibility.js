document.addEventListener('DOMContentLoaded', function() {
    // Elementos del modal
    const accessibilityBtn = document.getElementById('accessibilityBtn');
    const accessibilityModal = document.getElementById('accessibilityModal');
    const closeModal = document.getElementById('closeModal');
    
    // Elementos de configuración
    const speakModeToggle = document.getElementById('speakModeToggle');
    const speedControl = document.getElementById('speedControl');
    const speechSpeed = document.getElementById('speechSpeed');
    const decreaseFont = document.getElementById('decreaseFont');
    const normalFont = document.getElementById('normalFont');
    const increaseFont = document.getElementById('increaseFont');
    const highContrastToggle = document.getElementById('highContrastToggle');
    
    // Abrir modal
    accessibilityBtn.addEventListener('click', function() {
        accessibilityModal.classList.remove('hidden');
    });
    
    // Cerrar modal
    closeModal.addEventListener('click', function() {
        accessibilityModal.classList.add('hidden');
    });

    // Modifica el event listener del alto contraste
    highContrastToggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('high-contrast');
            // Forzar que el modal sea visible
            document.getElementById('accessibilityModal').classList.add('force-visible');
        } else {
            document.body.classList.remove('high-contrast');
            document.getElementById('accessibilityModal').classList.remove('force-visible');
        }
        localStorage.setItem('highContrast', this.checked);
    });

    // Agrega esto junto con los otros event listeners
    document.getElementById('resetSettings').addEventListener('click', function() {
        // Restablecer controles visuales
        speakModeToggle.checked = false;
        speedControl.classList.add('hidden');
        document.body.removeAttribute('data-speech-speed');
        speechSpeed.value = 1;
        
        highContrastToggle.checked = false;
        document.body.classList.remove('high-contrast');
        
        document.documentElement.style.fontSize = '100%';
        document.body.removeAttribute('data-font-size');
        
        // Desactivar modo hablar si estaba activo
        disableSpeakMode();
        document.body.removeAttribute('data-speak-mode');
        
        // Limpiar resaltados
        document.querySelectorAll('.speak-border-highlight').forEach(el => {
            el.classList.remove('speak-border-highlight');
        });
        
        // Eliminar preferencias guardadas
        localStorage.removeItem('fontSize');
        localStorage.removeItem('speakMode');
        localStorage.removeItem('speechSpeed');
        localStorage.removeItem('highContrast');
        
    });
    
    // Cerrar al hacer clic fuera del modal
    accessibilityModal.addEventListener('click', function(e) {
        if (e.target === accessibilityModal) {
            accessibilityModal.classList.add('hidden');
        }
    });
    
    // Toggle modo hablar
    speakModeToggle.addEventListener('change', function() {
        if (this.checked) {
            speedControl.classList.remove('hidden');
            document.body.setAttribute('data-speak-mode', 'true');
            // Habilitar el modo de tocar y hablar
            enableSpeakMode();
        } else {
            speedControl.classList.add('hidden');
            document.body.removeAttribute('data-speak-mode');
            // Deshabilitar el modo de tocar y hablar
            disableSpeakMode();
        }
    });
    
    // Control de velocidad de habla
    speechSpeed.addEventListener('input', function() {
        document.body.setAttribute('data-speech-speed', this.value);
    });
    
    // Control de tamaño de fuente
    decreaseFont.addEventListener('click', function() {
        document.documentElement.style.fontSize = '90%';
        document.body.setAttribute('data-font-size', 'small');
    });
    
    normalFont.addEventListener('click', function() {
        document.documentElement.style.fontSize = '100%';
        document.body.removeAttribute('data-font-size');
    });
    
    increaseFont.addEventListener('click', function() {
        document.documentElement.style.fontSize = '110%';
        document.body.setAttribute('data-font-size', 'large');
    });
    
    // Toggle alto contraste
    highContrastToggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('high-contrast');
        } else {
            document.body.classList.remove('high-contrast');
        }
    });
    
    // Funciones para modo hablar
    function enableSpeakMode() {
        document.addEventListener('click', speakElement);
    }
    
    function disableSpeakMode() {
        document.removeEventListener('click', speakElement);
    }
    
    function speakElement(e) {
        if (e.target.getAttribute('data-no-speak') === 'true' || 
            e.target.closest('#accessibilityModal') || 
            e.target === accessibilityBtn) return;
        
        // Quitar resaltados anteriores
        document.querySelectorAll('.speak-border-highlight').forEach(el => {
            el.classList.remove('speak-border-highlight');
        });
        
        // Aplicar resaltado al elemento clickeado
        e.target.classList.add('speak-border-highlight');
        
        // También agregamos un efecto de "pulso"
        const highlight = document.createElement('div');
        highlight.classList.add('speak-highlight');
        highlight.style.position = 'absolute';
        highlight.style.top = `${e.clientY}px`;
        highlight.style.left = `${e.clientX}px`;
        highlight.style.width = '20px';
        highlight.style.height = '20px';
        highlight.style.borderRadius = '50%';
        highlight.style.pointerEvents = 'none';
        document.body.appendChild(highlight);
        
        // Eliminar el efecto después de la animación
        setTimeout(() => {
            highlight.remove();
        }, 1500);
        
        const textToSpeak = e.target.textContent.trim() || 
                            e.target.getAttribute('aria-label') || 
                            e.target.getAttribute('alt') || 
                            e.target.title;
        
        if (textToSpeak) {
            const speed = parseFloat(document.body.getAttribute('data-speech-speed')) || 1;
            const utterance = new SpeechSynthesisUtterance(textToSpeak);
            utterance.rate = speed;
            window.speechSynthesis.cancel();
            window.speechSynthesis.speak(utterance);
            
            // Quitar el resaltado cuando termine de hablar
            utterance.onend = function() {
                setTimeout(() => {
                    e.target.classList.remove('speak-border-highlight');
                }, 1000);
            };
        }
    }
    
    // Cargar preferencias guardadas
    loadPreferences();
    
    function loadPreferences() {
        // Tamaño de fuente
        if (localStorage.getItem('fontSize') === 'small') {
            decreaseFont.click();
        } else if (localStorage.getItem('fontSize') === 'large') {
            increaseFont.click();
        }
        
        // Modo hablar
        if (localStorage.getItem('speakMode') === 'true') {
            speakModeToggle.click();
            const savedSpeed = localStorage.getItem('speechSpeed');
            if (savedSpeed) {
                speechSpeed.value = savedSpeed;
                document.body.setAttribute('data-speech-speed', savedSpeed);
            }
        }
        
        // Alto contraste
        if (localStorage.getItem('highContrast') === 'true') {
            highContrastToggle.click();
        }
    }
    
    // Guardar preferencias cuando cambien
    document.querySelectorAll('#decreaseFont, #normalFont, #increaseFont').forEach(btn => {
        btn.addEventListener('click', function() {
            const fontSize = document.body.getAttribute('data-font-size') || 'normal';
            localStorage.setItem('fontSize', fontSize);
        });
    });
    
    speakModeToggle.addEventListener('change', function() {
        localStorage.setItem('speakMode', this.checked);
    });
    
    speechSpeed.addEventListener('input', function() {
        localStorage.setItem('speechSpeed', this.value);
    });
    
    highContrastToggle.addEventListener('change', function() {
        localStorage.setItem('highContrast', this.checked);
    });
});

// Función para verificar si es la primera visita
function checkFirstVisit() {
    // Verificar si ya ha visitado antes (usando localStorage)
    if (!localStorage.getItem('accessibilityPromptShown')) {
        // Mostrar el modal de bienvenida después de un breve retraso
        setTimeout(() => {
            document.getElementById('welcomeModal').classList.remove('hidden');
        }, 1);
    }
}

// Event listeners para los botones del modal de bienvenida
document.getElementById('setupAccessibility').addEventListener('click', function() {
    document.getElementById('welcomeModal').classList.add('hidden');
    document.getElementById('accessibilityModal').classList.remove('hidden');
    localStorage.setItem('accessibilityPromptShown', 'true');
});

document.getElementById('skipSetup').addEventListener('click', function() {
    document.getElementById('welcomeModal').classList.add('hidden');
    localStorage.setItem('accessibilityPromptShown', 'true');
});

// Llamar a esta función cuando se cargue la página
document.addEventListener('DOMContentLoaded', function() {
    // ... (tu código existente)
    
    checkFirstVisit(); // Agregar esta línea al final
});