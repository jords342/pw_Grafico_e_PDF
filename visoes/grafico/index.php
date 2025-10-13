<?php require __DIR__ . '/../templates/cabecalho.php'; ?>

<div class="card p-3 mb-4">
    <h2 class="mb-3">Resumo Gráfico de Preços</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Relatório Detalhado</h2>
        <button id="gerarPdf" class="btn btn-primary">
            <i class="bi bi-file-earmark-pdf-fill"></i> Gerar Relatório em PDF
        </button>
    </div>
    <p>Clique no botão acima para gerar um relatório completo contendo o gráfico de resumo e os detalhes de cada
        veículo.</p>

    <canvas id="graficoPrecos"></canvas>
</div>


<?php require __DIR__ . '/../templates/rodape.php'; ?>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const carros = <?= json_encode($carros, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;
        const botaoPdf = document.getElementById('gerarPdf');
        const conteudoOriginalBotao = botaoPdf.innerHTML;

        const nomes = carros.map(carro => carro.nome);
        const precos = carros.map(carro => carro.preco);

        const canvasElement = document.getElementById('graficoPrecos');
        const ctx = canvasElement.getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: { labels: nomes, datasets: [{ label: 'Preço (R$)', data: precos, backgroundColor: 'rgba(0, 123, 255, 0.6)', borderColor: 'rgba(0, 123, 255, 1)', borderWidth: 1 }] },
            options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false }, title: { display: true, text: 'Comparativo de Preços por Veículo' } }, scales: { y: { beginAtZero: true, ticks: { callback: value => 'R$ ' + value.toLocaleString('pt-BR') } } } }
        });

        function carregarImagemBase64(url) {
            return new Promise((resolve) => {
                if (!url) return resolve(null);
                const img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const canvasCtx = canvas.getContext('2d');
                    canvasCtx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                img.onerror = () => resolve(null);
                img.src = url;
            });
        }

        async function gerarRelatorioPDF() {
            botaoPdf.disabled = true;
            botaoPdf.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Gerando...`;

            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');
                const margin = 15;
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();

                doc.setFontSize(22);
                doc.text('Relatório de Veículos', pageWidth / 2, margin, { align: 'center' });

                const graficoImgData = await html2canvas(canvasElement.parentElement, { scale: 2 }).then(c => c.toDataURL('image/png'));
                const imgProps = doc.getImageProperties(graficoImgData);
                const ratio = imgProps.width / imgProps.height;
                const imgWidth = pageWidth - (margin * 2);
                const imgHeight = imgWidth / ratio;
                doc.addImage(graficoImgData, 'PNG', margin, margin + 15, imgWidth, imgHeight);

                if (carros.length > 0) {
                    doc.addPage();
                }
                let cursorY = margin;

                doc.setFontSize(18);
                doc.text('Detalhes dos Veículos', margin, cursorY);
                cursorY += 10;

                for (const carro of carros) {
                    const espacoNecessario = 75;
                    if (cursorY + espacoNecessario > pageHeight - margin) {
                        doc.addPage();
                        cursorY = margin;
                    }

                    const caminhoFoto = `publico/uploads/${carro.foto}`;
                    const fotoCarroImgData = await carregarImagemBase64(caminhoFoto);

                    if (fotoCarroImgData) {
                        const fotoProps = doc.getImageProperties(fotoCarroImgData);
                        const fotoRatio = fotoProps.width / fotoProps.height;
                        const fotoWidth = 60;
                        const fotoHeight = fotoWidth / fotoRatio;
                        doc.addImage(fotoCarroImgData, 'PNG', margin, cursorY, fotoWidth, fotoHeight);
                    }

                    const textoX = margin + 70;
                    let textoY = cursorY + 5;

                    doc.setFontSize(16).setFont(undefined, 'bold');
                    doc.text(carro.nome, textoX, textoY);
                    textoY += 10;

                    doc.setFontSize(12).setFont(undefined, 'normal');
                    const precoFmt = `Preço: R$ ${parseFloat(carro.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;
                    doc.text(precoFmt, textoX, textoY);
                    textoY += 10;

                    doc.setFontSize(10);
                    const descLines = doc.splitTextToSize(carro.descricao, pageWidth - (margin * 2) - 70);
                    doc.text(descLines, textoX, textoY);

                    cursorY += espacoNecessario - 10;
                    doc.setDrawColor(200).line(margin, cursorY, pageWidth - margin, cursorY);
                    cursorY += 5;
                }

                doc.save('relatorio-completo-veiculos.pdf');

            } catch (error) {
                console.error("Ocorreu um erro ao gerar o PDF:", error);
                alert("Desculpe, não foi possível gerar o PDF. Verifique o console para mais detalhes.");
            } finally {
                botaoPdf.disabled = false;
                botaoPdf.innerHTML = conteudoOriginalBotao;
            }
        }

        botaoPdf.addEventListener('click', gerarRelatorioPDF);
    });
</script>