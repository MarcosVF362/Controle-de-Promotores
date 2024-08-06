document.addEventListener('DOMContentLoaded', function() {
    const pesquisaInput = document.getElementById('pesquisa');
    const pesquisarButton = document.getElementById('pesquisar');
    const resultadoPesquisa = document.getElementById('resultadoPesquisa');

    pesquisarButton.addEventListener('click', function() {
        const query = pesquisaInput.value;

        fetch('pesquisar_promotor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `query=${encodeURIComponent(query)}`
        })
        .then(response => response.json())
        .then(data => {
            resultadoPesquisa.innerHTML = '';

            if (data.length > 0) {
                data.forEach(promotor => {
                    const div = document.createElement('div');
                    div.classList.add('promotor');
                    div.innerHTML = `
                        <p>Nome: ${promotor.nome}</p>
                        <p>CPF: ${promotor.cpf}</p>
                        <p>Empresa: ${promotor.empresa}</p>
                        <button type="button" onclick="registrarEntrada(${promotor.id})">Registrar Entrada</button>
                    `;
                    resultadoPesquisa.appendChild(div);
                });
            } else {
                resultadoPesquisa.innerHTML = '<p>Nenhum promotor encontrado</p>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });
});

function registrarEntrada(promotorId) {
    const responsavelEntrada = prompt('Digite o nome do responsável pela entrada:');

    fetch('registrar_entrada.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `promotor_id=${promotorId}&responsavel_entrada=${encodeURIComponent(responsavelEntrada)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}

function registrarSaida(entradaId) {
    const responsavelSaida = prompt('Digite o nome do responsável pela saída:');

    fetch('registrar_saida.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `entrada_id=${entradaId}&responsavel_saida=${encodeURIComponent(responsavelSaida)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        document.getElementById(`entrada-${entradaId}`).style.backgroundColor = 'green';
    })
    .catch(error => {
        console.error('Erro:', error);
    });
}
