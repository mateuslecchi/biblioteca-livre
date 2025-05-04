<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Livre de Coqueiral</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: opacity 2s ease-in-out;
            opacity: 0;
        }

        .background.active {
            opacity: 1;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .mural {
            position: relative;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 700px;
            margin: auto;
        }

        .highlight {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
        }

        .info {
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .poema {
            font-style: italic;
            margin-top: 2rem;
            border-top: 1px solid #ccc;
            padding-top: 1rem;
            font-size: 1rem;
            color: #555;
        }

        @media (max-width: 768px) {
            .mural {
                padding: 1rem;
                margin: 1rem;
            }

            .highlight {
                font-size: 1.5rem;
            }

            .info, .poema {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <!-- Backgrounds -->
    <div id="bg1" class="background active"></div>
    <div id="bg2" class="background"></div>
    <div class="overlay"></div>

    <!-- Mural de Avisos -->
    <div class="d-flex align-items-center justify-content-center h-100">
        <div class="mural text-center">
            <div class="highlight">Biblioteca Livre de Coqueiral</div>
            <div class="info mt-3">
                <p><strong>📍 Localização:</strong> Praça Central de Coqueiral, Aracruz - ES</p>
                <p><strong>📞 Contato:</strong> (27) 99999-0000 | bibliotecacoqueiral@exemplo.com</p>
                <p><strong>⏰ Horário de Funcionamento:</strong> Segunda a Sexta, 8h às 18h</p>
            </div>
            <div class="poema">
                <p>
                    “Num livro há mais do que papel e tinta,<br>
                    Há mundos inteiros à nossa espera.<br>
                    Onde a mente voa, a alma brinca,<br>
                    E o saber floresce como primavera.”<br>
                    <small>– Autor Desconhecido</small>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>

        //para usar imagens proprias, basta alterar o array :)
        const images = [
            'https://images.unsplash.com/photo-1529156069898-49953e39b3ac',
            'https://images.unsplash.com/photo-1507842217343-583bb7270b66',
            'https://images.unsplash.com/photo-1519681393784-d120267933ba',
            'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c'
        ];

        let current = 0;
        const bg1 = document.getElementById('bg1');
        const bg2 = document.getElementById('bg2');

        function changeBackground() {
            const next = (current + 1) % images.length;

            const [currentDiv, nextDiv] = current % 2 === 0 ? [bg1, bg2] : [bg2, bg1];

            nextDiv.style.backgroundImage = `url('${images[next]}')`;
            nextDiv.classList.add('active');
            currentDiv.classList.remove('active');

            current = next;
        }

        // Inicializa a primeira imagem
        bg1.style.backgroundImage = `url('${images[0]}')`;

        // Troca a imagem a cada 8 segundos
        setInterval(changeBackground, 8000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
