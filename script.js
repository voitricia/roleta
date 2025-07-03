// Variáveis globais passadas pelo PHP
// const premios = ['Prêmio A', 'Prêmio B', ...];
// const podeGirar = true;

let theWheel;
let wheelSpinning = false;

// Só tenta criar a roleta se o usuário puder girar
if (podeGirar) {
    // Mapeia os prêmios para o formato do Winwheel
    const segments = premios.map(p => ({ 'fillStyle': getRandomColor(), 'text': p }));

    theWheel = new Winwheel({
        'canvasId': 'canvas',
        'numSegments': segments.length,
        'outerRadius': 180,
        'textFontSize': 16,
        'segments': segments,
        'animation': {
            'type': 'spinToStop',
            'duration': 8,
            'spins': 10,
            'callbackFinished': alertPrize,
            'callbackAfter': drawTriangle,
        }
    });

    // Desenha o ponteiro uma vez no início para a roleta aparecer imediatamente.
    drawTriangle();
}

// ==========================================================
// FUNÇÃO startSpin() CORRIGIDA
// ==========================================================
function startSpin() {
    // Não faz nada se já estiver girando ou se não puder girar
    if (wheelSpinning || !podeGirar) {
        return;
    }

    // Desativa o botão
    document.getElementById('spin_button').disabled = true;
    wheelSpinning = true;

    // Chama o servidor para sortear um prêmio e registrar o giro.
    fetch('/projeto_roleta/api/girar_roleta.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                document.getElementById('spin_button').disabled = false;
                wheelSpinning = false;
                return;
            }

            if (data.success) {
                const premioSorteado = data.premio_nome;
                
                // Encontra o NÚMERO do segmento que corresponde ao prêmio.
                // A biblioteca Winwheel numera os segmentos a partir de 1.
                let winningSegmentNumber = 0;
                for (let i = 1; i <= theWheel.numSegments; i++) {
                    if (theWheel.segments[i] && theWheel.segments[i].text === premioSorteado) {
                        winningSegmentNumber = i;
                        break;
                    }
                }

                if (winningSegmentNumber > 0) {
                    // CÁLCULO CORRETO DO ÂNGULO DE PARADA:
                    // 1. Pegamos o tamanho de cada fatia.
                    const anglePerSegment = 360 / theWheel.numSegments;
                    // 2. Calculamos o ângulo inicial e final do segmento vencedor.
                    const startAngle = (winningSegmentNumber - 1) * anglePerSegment;
                    const endAngle = startAngle + anglePerSegment;
                    // 3. Geramos um ângulo aleatório DENTRO desse segmento para a parada ser mais natural.
                    // (Adicionamos uma pequena margem para não parar exatamente na linha)
                    const stopAt = Math.floor(Math.random() * (endAngle - startAngle - 10)) + startAngle + 5;

                    // Define o stopAngle na animação.
                    theWheel.animation.stopAngle = stopAt;

                    // Inicia a animação de giro.
                    theWheel.startAnimation();
                } else {
                    alert('Erro: prêmio sorteado (' + premioSorteado + ') não encontrado na roleta.');
                    wheelSpinning = false;
                    document.getElementById('spin_button').disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Erro na chamada da API ou no processamento do JSON:', error);
            alert('Ocorreu um erro ao processar o giro. Verifique o console.');
            document.getElementById('spin_button').disabled = false;
            wheelSpinning = false;
        });
}

// Função chamada quando o giro termina
function alertPrize(indicatedSegment) {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `Parabéns! Você ganhou: <strong>${indicatedSegment.text}</strong>! A página será atualizada.`;
    resultDiv.style.display = 'block';

    // Recarrega a página após 3 segundos para mostrar a mensagem "já girou hoje"
    setTimeout(() => {
        window.location.reload();
    }, 3000);
}

// Função para desenhar o ponteiro que indica o prêmio
function drawTriangle() {
    let canvas = document.getElementById('canvas');
    if (canvas.getContext) {
        let ctx = canvas.getContext('2d');
        ctx.strokeStyle = '#000000';
        ctx.fillStyle = '#ffffff';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(180, 0);
        ctx.lineTo(220, 0);
        ctx.lineTo(200, 40);
        ctx.lineTo(181, 0);
        ctx.stroke();
        ctx.fill();
    }
}

// Função para gerar cores aleatórias
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}