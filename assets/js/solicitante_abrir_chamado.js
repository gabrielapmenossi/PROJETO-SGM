// =========================
// CARREGAR DADOS INICIAIS
// =========================
async function iniciar() {

    try {

        // =========================
        // BLOCOS
        // =========================
        const resB =
            await fetch(
                'api/localizacoes.php?acao=listar_blocos'
            );

        const blocos =
            await resB.json();

        console.log("BLOCOS:", blocos);

        const selB =
            document.getElementById('selectBloco');

        selB.innerHTML =
            '<option value="">Selecione o bloco</option>';

        blocos.forEach(b => {

            selB.innerHTML += `
                <option value="${b.id_bloco}">
                    ${b.nome}
                </option>
            `;

        });


        // =========================
        // TIPOS
        // =========================
        const resT =
            await fetch(
                'api/localizacoes.php?acao=listar_tipos'
            );

        const tipos =
            await resT.json();

        console.log("TIPOS:", tipos);

        const selT =
            document.getElementById('selectTipo');

        selT.innerHTML =
            '<option value="">Selecione o tipo</option>';

        tipos.forEach(t => {

            selT.innerHTML += `
                <option value="${t.id_tipo}">
                    ${t.nome}
                </option>
            `;

        });

    } catch(error){

        console.error(error);

        alert(
            "Erro ao carregar blocos ou tipos."
        );

    }

}


// =========================
// CARREGAR AMBIENTES
// =========================
async function carregarAmbientes(id_bloco) {

    const selA =
        document.getElementById('selectAmbiente');

    if (!id_bloco) {

        selA.innerHTML =
            '<option value="">Selecione a Sala...</option>';

        selA.disabled = true;

        return;
    }

    try {

        const res =
            await fetch(
                `api/localizacoes.php?acao=listar_ambientes&id_bloco=${id_bloco}`
            );

        const ambientes =
            await res.json();

        console.log("AMBIENTES:", ambientes);

        selA.innerHTML =
            '<option value="">Selecione a Sala...</option>';

        ambientes.forEach(a => {

            selA.innerHTML += `
                <option value="${a.id_ambiente}">
                    ${a.nome}
                </option>
            `;

        });

        selA.disabled = false;

    } catch(error){

        console.error(error);

        alert(
            "Erro ao carregar ambientes."
        );

    }

}


// =========================
// EVENTO DO SELECT BLOCO
// =========================
document.getElementById('selectBloco')
.addEventListener('change', function(){

    carregarAmbientes(this.value);

});


// =========================
// ENVIAR CHAMADO
// =========================
document.getElementById('formChamado')
.addEventListener('submit', async (e) => {

    e.preventDefault();

    try {

        const formData = new FormData();

        formData.append(
            'id_ambiente',
            document.getElementById('selectAmbiente').value
        );

        formData.append(
            'id_tipo',
            document.getElementById('selectTipo').value
        );

        formData.append(
            'descricao',
            document.getElementById('descricao').value
        );

        const fotoFile =
            document.getElementById('foto').files[0];

        if (fotoFile) {

            formData.append('foto', fotoFile);

        }

        const response =
            await fetch(
                'api/salvar_chamado.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

        const result =
            await response.json();

        console.log(result);

        if (result.success) {

            alert(result.message);

            window.location.href =
                'solicitante_dashboard.php';

        } else {

            alert(
                "Erro: " + result.message
            );

        }

    } catch(error){

        console.error(error);

        alert(
            "Erro ao enviar chamado."
        );

    }

});


// =========================
// INICIAR
// =========================
iniciar();