<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CarStore - Hệ thống bán xe')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Gọi file header nằm ngang cấp trong thư mục views --}}
    @include('header')

    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Gọi file footer nằm ngang cấp trong thư mục views --}}
    @include('footer')

    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <div id="chat-window" class="hidden w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col mb-4 overflow-hidden origin-bottom-right transition-all duration-300 h-[500px]">
            <div class="bg-blue-600 text-white p-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Trợ lý CarStore (AI)</h4>
                        <p class="text-[10px] text-blue-100"><span class="w-2 h-2 inline-block bg-green-400 rounded-full animate-pulse mr-1"></span>Đang trực tuyến</p>
                    </div>
                </div>
                <button onclick="toggleChat()" class="text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 bg-gray-50 flex flex-col gap-3 text-sm border-t border-b border-gray-100 min-h-0">
                <div class="bg-blue-100 text-blue-800 p-3 rounded-2xl rounded-tl-sm w-5/6 shadow-sm">
                    Xin chào! Tôi là trợ lý AI của CarStore. Bạn cần tìm xe tầm giá bao nhiêu hoặc xe của hãng nào?
                </div>
            </div>

            <div class="p-3 bg-white border-t border-gray-100 flex items-center gap-2 shrink-0">
                <input type="text" id="chat-input" class="flex-1 bg-gray-100 rounded-full px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500 transition text-sm" placeholder="Nhập câu hỏi...">
                <button onclick="sendMessage()" id="send-btn" class="w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition flex items-center justify-center shadow-md">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <button onclick="toggleChat()" id="chat-toggle-btn" class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-2xl hover:bg-blue-700 hover:scale-110 transition-all flex items-center justify-center text-2xl group">
            <i class="fas fa-comment-dots group-hover:hidden"></i>
            <i class="fas fa-headset hidden group-hover:block"></i>
        </button>
    </div>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        const chatWindow = document.getElementById('chat-window');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const sendBtn = document.getElementById('send-btn');

        function toggleChat() { chatWindow.classList.toggle('hidden'); }
        chatInput.addEventListener('keypress', function (e) { if (e.key === 'Enter') sendMessage(); });

        async function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;
            appendMessage('user', message);
            chatInput.value = '';
            
            const typingId = 'typing-' + Date.now();
            chatMessages.innerHTML += `<div id="${typingId}" class="bg-gray-200 p-3 rounded-2xl w-fit text-xs text-gray-500">Đang gõ...</div>`;
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            chatInput.disabled = true; sendBtn.disabled = true;

            try {
                const res = await fetch('/api/chatbot', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ message: message })
                });
                const data = await res.json();
                document.getElementById(typingId).remove();
                appendMessage('ai', data.reply);
            } catch (err) {
                document.getElementById(typingId).remove();
                appendMessage('ai', 'Lỗi kết nối mạng.');
            } finally {
                chatInput.disabled = false; sendBtn.disabled = false; chatInput.focus();
            }
        }

        function appendMessage(sender, text) {
            const div = document.createElement('div');
            if (sender === 'user') {
                div.className = "bg-blue-600 text-white p-3 rounded-2xl rounded-tr-sm w-fit max-w-[85%] self-end shadow-sm";
                div.textContent = text;
            } else {
                div.className = "bg-blue-100 text-blue-900 p-3 rounded-2xl rounded-tl-sm w-fit max-w-[85%] shadow-sm leading-relaxed";
                div.innerHTML = marked.parse(text); 
            }
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</body>
</html>