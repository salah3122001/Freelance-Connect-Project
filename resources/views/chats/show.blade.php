@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container">
        <h3>Chat for Order #{{ $order->id }}</h3>

        <div id="chat-box" class="border rounded p-3 mb-3 bg-light" style="height: 400px; overflow-y: auto;">
            @foreach ($chat->messages as $message)
                <div
                    class="d-flex {{ $message->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 mb-2 rounded {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-danger border' }}"
                        style="max-width: 70%;">
                        <strong>{{ $message->sender->name }}</strong>
                        <p class="mb-1">{{ $message->message }}</p>
                        @if ($message->file_path)
                            <a href="{{ asset('storage/' . $message->file_path) }}" target="_blank" class="text-light">📎
                                File</a>
                        @endif
                        <small class="text-muted d-block">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        </div>


        <form id="chat-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <textarea id="message-input" name="message" class="form-control" placeholder="Type your message..." rows="3"></textarea>
            </div>
            <div class="mb-3">
                <input type="file" name="file" class="form-control" id="file-input">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chat-box');
            const form = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const fileInput = document.getElementById('file-input');

            // التمرير لأسفل عند التحميل
            chatBox.scrollTop = chatBox.scrollHeight;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const response = await fetch("{{ route('chat.send', $chat->id) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const error = await response.json();
                        alert(error.error || 'Error sending message');
                        return;
                    }

                    const result = await response.json();

                    // لا نضيف الرسالة هنا لأنها ستأتي عبر البث
                    // فقط نظف الحقول
                    messageInput.value = '';
                    fileInput.value = '';

                } catch (error) {
                    console.error('Error:', error);
                    alert('Network error');
                }
            });

            function appendMessage(message, isOwn = false) {
                // تحقق إذا كانت الرسالة موجودة مسبقاً
                const existingMessage = document.querySelector(`[data-message-id="${message.id}"]`);
                if (existingMessage) {
                    return; // لا تضيف إذا موجودة
                }

                const div = document.createElement('div');
                div.classList.add('mb-2', 'message-item');
                div.setAttribute('data-message-id', message.id);

                if (isOwn) {
                    div.classList.add('text-end');
                } else {
                    div.classList.add('text-start');
                }

                div.innerHTML = `
                    <strong>${message.sender.name}:</strong>
                    <p class="mb-1">${message.message || ''}</p>
                    ${message.file_path ? `<a href="/storage/${message.file_path}" target="_blank" class="d-block">📎 View File</a>` : ''}
                    <small class="text-muted d-block">${message.created_at}</small>
                `;

                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // الاستماع للبث - الطريقتين
            // window.Echo.channel('chat.{{ $chat->id }}')
            //     .listen('.message.sent', (e) => {
            //         // أضف الرسالة للجميع
            //         appendMessage(e.message, e.message.sender.id === {{ Auth::id() }});
            //     });

            // بديل: إذا ما شتغلتش الطريقة الأولى
            window.Echo.channel('chat.{{ $chat->id }}')
                .listen('.MessageSent', (e) => {
                    appendMessage(e.message, e.message.sender.id === {{ Auth::id() }});
                });
        });
    </script>
@endsection
