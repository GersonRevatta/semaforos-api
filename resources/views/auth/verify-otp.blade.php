<!DOCTYPE html>
<html>
<head>
    <title>Verificación de OTP</title>
</head>
<body>
    <h1>Verificación de OTP</h1>
    @if(isset($message))
        <div style="margin-bottom: 20px; color: {{ $message == 'OTP validado exitosamente. Usuario validado.' ? 'green' : 'red' }}">
            {{ $message }}
        </div>
    @endif
</body>
</html>
