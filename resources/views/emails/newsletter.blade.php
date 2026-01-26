<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Newsletter</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 8px;">

        <h2 style="color: #e91e63; margin-bottom: 20px;">
            Novedades de nuestra tienda
        </h2>

        <p style="font-size: 16px; color: #333;">
            {!! nl2br(e($content)) !!}
        </p>

        <hr style="margin: 30px 0;">

        <p style="font-size: 12px; color: #777;">
            Recibes este correo porque te suscribiste a nuestro newsletter.
        </p>

    </div>

</body>
</html>