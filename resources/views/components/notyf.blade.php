@if (session('status'))
    <script>
        window.addEventListener('load', function () {
            document.dispatchEvent(new CustomEvent('notyf:success', {
                detail: {
                    message: @json(session('status'))
                }
            }));
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('load', function () {
            document.dispatchEvent(new CustomEvent('notyf:error', {
                detail: {
                    message: @json(session('error'))
                }
            }));
        });
    </script>
@endif
