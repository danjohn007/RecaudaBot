<div class="row">
    <div class="col-12">
        <h1><i class="bi bi-robot"></i> Asistente Virtual</h1>
        <p class="lead">Chat en línea disponible 24/7</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-chat-dots"></i> RecaudaBot - Asistente Virtual</h5>
                <small>Pregúntame sobre trámites municipales, horarios, requisitos y más</small>
            </div>
            <div class="card-body p-0">
                <div id="chatMessages" class="p-3" style="height: 500px; overflow-y: auto; background-color: #f8f9fa;">
                    <div class="chat-message bot-message mb-3">
                        <div class="d-flex">
                            <div class="bg-warning text-dark rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                                <i class="bi bi-robot"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="bg-white p-3 rounded shadow-sm">
                                    <strong>RecaudaBot</strong>
                                    <p class="mb-0">¡Hola! Soy RecaudaBot, tu asistente virtual. ¿En qué puedo ayudarte hoy?</p>
                                    <small class="text-muted">Puedes preguntarme sobre:</small>
                                    <ul class="mb-0 mt-2">
                                        <li>Trámites municipales</li>
                                        <li>Pagos de impuestos</li>
                                        <li>Licencias de funcionamiento</li>
                                        <li>Multas y sanciones</li>
                                        <li>Horarios de atención</li>
                                        <li>Documentos necesarios</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row mb-2">
                    <div class="col-12">
                        <small class="text-muted">Preguntas sugeridas:</small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-sm btn-outline-secondary quick-question" data-question="¿Cómo pago mi impuesto predial?">
                                <i class="bi bi-house"></i> Impuesto Predial
                            </button>
                            <button class="btn btn-sm btn-outline-secondary quick-question" data-question="¿Qué necesito para una licencia de funcionamiento?">
                                <i class="bi bi-file-earmark"></i> Licencia
                            </button>
                            <button class="btn btn-sm btn-outline-secondary quick-question" data-question="¿Cómo consulto mis multas?">
                                <i class="bi bi-exclamation-triangle"></i> Multas
                            </button>
                            <button class="btn btn-sm btn-outline-secondary quick-question" data-question="¿Cuál es el horario de atención?">
                                <i class="bi bi-clock"></i> Horarios
                            </button>
                        </div>
                    </div>
                </div>
                <form id="chatForm">
                    <div class="input-group">
                        <input type="text" class="form-control" id="userMessage" placeholder="Escribe tu pregunta aquí..." required>
                        <button class="btn btn-warning" type="submit">
                            <i class="bi bi-send"></i> Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-body">
                <h6><i class="bi bi-info-circle"></i> Sobre el Asistente Virtual</h6>
                <p class="mb-2 small">
                    <strong>Disponibilidad:</strong> 24 horas al día, 7 días a la semana
                </p>
                <p class="mb-2 small">
                    <strong>Capacidades:</strong> Respondo preguntas sobre trámites, pagos, requisitos y procedimientos municipales.
                </p>
                <p class="mb-0 small">
                    <strong>Nota:</strong> Para casos complejos o atención personalizada, te recomiendo 
                    <a href="<?php echo BASE_URL; ?>/citas/agendar">agendar una cita</a> o 
                    contactar directamente con nuestras oficinas.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.chat-message {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.user-message {
    text-align: right;
}

.user-message .d-flex {
    flex-direction: row-reverse;
}

.user-message .bg-primary {
    margin-left: 0.5rem;
    margin-right: 0;
}
</style>

<script>
const chatMessages = document.getElementById('chatMessages');
const chatForm = document.getElementById('chatForm');
const userMessageInput = document.getElementById('userMessage');

// Quick question buttons
document.querySelectorAll('.quick-question').forEach(button => {
    button.addEventListener('click', function() {
        const question = this.getAttribute('data-question');
        userMessageInput.value = question;
        chatForm.dispatchEvent(new Event('submit'));
    });
});

// Bot responses database
const botResponses = {
    'impuesto predial': {
        response: 'Para pagar tu impuesto predial puedes:<br>1. Ingresar a <strong>Impuesto Predial</strong> en el menú<br>2. Buscar tu predio con tu cuenta predial o dirección<br>3. Seleccionar el año a pagar<br>4. Realizar el pago en línea<br><br>También puedes pagar en ventanilla con descuentos por pronto pago.',
        links: [
            { text: 'Ir a Impuesto Predial', url: '/impuesto-predial' },
            { text: 'Ver Calculadora', url: '/orientacion/calculadoras' }
        ]
    },
    'licencia': {
        response: 'Para tramitar una licencia de funcionamiento necesitas:<br>1. Identificación oficial<br>2. Comprobante de domicilio del negocio<br>3. Uso de suelo favorable<br>4. Contrato de arrendamiento o escrituras<br>5. Comprobante de pago de derechos<br><br>El trámite puede realizarse en línea para nuevo establecimiento o renovación.',
        links: [
            { text: 'Iniciar Trámite', url: '/licencias/nueva' },
            { text: 'Ver Calculadora de Costos', url: '/orientacion/calculadoras' }
        ]
    },
    'multas': {
        response: 'Para consultar tus multas puedes:<br><strong>Multas de Tránsito:</strong><br>- Buscar por número de placa<br>- Buscar por número de licencia<br>- Buscar por folio de infracción<br><br><strong>Multas Cívicas:</strong><br>- Consultar con tu RFC o CURP<br><br>Recuerda que el pago dentro de los primeros días tiene descuento.',
        links: [
            { text: 'Consultar Multas de Tránsito', url: '/multas-transito/consultar' },
            { text: 'Consultar Multas Cívicas', url: '/multas-civicas/consultar' }
        ]
    },
    'horarios': {
        response: 'Nuestros horarios de atención son:<br><strong>Atención en línea:</strong> 24/7 (siempre disponible)<br><strong>Oficinas físicas:</strong> Lunes a Viernes de 8:00 AM a 4:00 PM<br><strong>Atención telefónica:</strong> Lunes a Viernes de 8:00 AM a 6:00 PM<br>Línea gratuita: 01 800 123 4567',
        links: [
            { text: 'Agendar Cita', url: '/citas/agendar' }
        ]
    },
    'cita': {
        response: 'Para agendar una cita:<br>1. Debes estar registrado e iniciar sesión<br>2. Selecciona el tipo de trámite<br>3. Elige fecha y hora disponibles<br>4. Confirma tu cita<br><br>Recibirás un comprobante por correo. Te recomendamos llegar 10 minutos antes.',
        links: [
            { text: 'Agendar Cita', url: '/citas/agendar' },
            { text: 'Mis Citas', url: '/citas/mis-citas' }
        ]
    },
    'documentos': {
        response: 'Los documentos varían según el trámite:<br><strong>General:</strong><br>- Identificación oficial vigente<br>- CURP<br>- Comprobante de domicilio<br><br>Para trámites específicos, consulta la sección de <strong>Guías de Trámites</strong> donde encontrarás información detallada.',
        links: [
            { text: 'Ver Guías de Trámites', url: '/orientacion/guias' },
            { text: 'Preguntas Frecuentes', url: '/orientacion/faq' }
        ]
    },
    'pago': {
        response: 'Puedes realizar pagos mediante:<br>1. <strong>En línea:</strong> Tarjeta de crédito/débito (Visa, Mastercard)<br>2. <strong>Referencia bancaria:</strong> Genera una referencia y paga en bancos o tiendas<br>3. <strong>En ventanilla:</strong> Efectivo, cheque o tarjeta<br><br>Los pagos en línea se reflejan de inmediato.',
        links: [
            { text: 'Ver Comprobantes', url: '/comprobantes' }
        ]
    },
    'default': {
        response: 'Gracias por tu pregunta. Aquí hay algunas opciones que podrían ayudarte:<br><br>• Visita nuestra sección de <strong>Preguntas Frecuentes</strong><br>• Consulta las <strong>Guías de Trámites</strong><br>• Usa nuestras <strong>Calculadoras</strong> para estimar costos<br>• <strong>Agenda una cita</strong> para atención personalizada<br><br>Si necesitas ayuda específica, puedes llamar a nuestra línea gratuita: 01 800 123 4567',
        links: [
            { text: 'Preguntas Frecuentes', url: '/orientacion/faq' },
            { text: 'Guías de Trámites', url: '/orientacion/guias' },
            { text: 'Contactar', url: '/citas/agendar' }
        ]
    }
};

function getBotResponse(message) {
    const lowerMessage = message.toLowerCase();
    
    if (lowerMessage.includes('predial') || lowerMessage.includes('impuesto')) {
        return botResponses['impuesto predial'];
    } else if (lowerMessage.includes('licencia') || lowerMessage.includes('funcionamiento')) {
        return botResponses['licencia'];
    } else if (lowerMessage.includes('multa') || lowerMessage.includes('infracción')) {
        return botResponses['multas'];
    } else if (lowerMessage.includes('horario') || lowerMessage.includes('atención')) {
        return botResponses['horarios'];
    } else if (lowerMessage.includes('cita') || lowerMessage.includes('agendar')) {
        return botResponses['cita'];
    } else if (lowerMessage.includes('documento') || lowerMessage.includes('requisito')) {
        return botResponses['documentos'];
    } else if (lowerMessage.includes('pago') || lowerMessage.includes('pagar')) {
        return botResponses['pago'];
    } else {
        return botResponses['default'];
    }
}

function addMessage(message, isUser = false) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${isUser ? 'user-message' : 'bot-message'} mb-3`;
    
    if (isUser) {
        messageDiv.innerHTML = `
            <div class="d-flex">
                <div class="bg-primary text-white rounded-circle p-2 ms-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-person"></i>
                </div>
                <div class="flex-grow-1 text-end">
                    <div class="bg-primary text-white p-3 rounded shadow-sm d-inline-block" style="max-width: 80%;">
                        <strong>Tú</strong>
                        <p class="mb-0">${message}</p>
                    </div>
                </div>
            </div>
        `;
    } else {
        messageDiv.innerHTML = `
            <div class="d-flex">
                <div class="bg-warning text-dark rounded-circle p-2 me-2" style="width: 40px; height: 40px;">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="bg-white p-3 rounded shadow-sm">
                        <strong>RecaudaBot</strong>
                        <p class="mb-2">${message.response}</p>
                        ${message.links ? `
                            <div class="mt-2">
                                ${message.links.map(link => `
                                    <a href="<?php echo BASE_URL; ?>${link.url}" class="btn btn-sm btn-outline-warning me-1 mb-1">
                                        ${link.text}
                                    </a>
                                `).join('')}
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const message = userMessageInput.value.trim();
    if (!message) return;
    
    // Add user message
    addMessage(message, true);
    userMessageInput.value = '';
    
    // Simulate typing delay
    setTimeout(() => {
        const botResponse = getBotResponse(message);
        addMessage(botResponse, false);
    }, 500);
});
</script>
