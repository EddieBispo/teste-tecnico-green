<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-content" v-show="mostrarPrimeiroModal">
            <input v-model="nomeTarefa" type="text" placeholder="Nome da tarefa">
            <input v-model="descricaoTarefa" type="text" placeholder="Descrição">
            <input id="input-date" v-model="dataVencimento" type="date">
            <div id="button-content">
                <Button text="Cancelar" id="light" @click="$emit('close')"></Button>
                <Button text="Proximo" id="dark" @click="nextSegundoCard"></Button>
            </div>
        </div>

        <div class="modal-content" v-show="mostrarSegundoModal">
            <input v-model="nomeSubtarefa" type="text" placeholder="Nome da subtarefa">
            <input v-model="descricaoSubtarefa" type="text" placeholder="Descrição">
            <div id="button-content">
                <Button text="Cancelar" id="light" @click="$emit('close')"></Button>
                <Button text="Proximo" id="dark" @click="nextTerceiroCard"></Button>
            </div>
        </div>

        <div class="modal-content-second" v-show="mostrarTerceiroModal">
            <h2>{{ nomeTarefa }}</h2>
            <p>{{ descricaoTarefa }}</p>
            <p>{{ formattedDate }}</p>
            <h2>{{ nomeSubtarefa }}</h2>
            <p>{{ descricaoSubtarefa }}</p>
            <p>{{ formattedSubtarefaDate }}</p>
            <div id="button-content">
                <Button text="Cancelar" id="light" @click="$emit('close')"></Button>
                <Button text="Criar tarefa" id="dark" @click="newTask"></Button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import Button from './Button.vue';

const nomeTarefa = ref('');
const nomeSubtarefa = ref('');
const descricaoTarefa = ref('');
const descricaoSubtarefa = ref('');
const dataVencimento = ref('');

const subtarefas = ref([]);

const emit = defineEmits(['close']);

defineProps({
    isVisible: Boolean
});

const formattedDate = computed(() => {
    return dataVencimento.value ? new Intl.DateTimeFormat('pt-BR').format(new Date(dataVencimento.value)) : 'Sem data definida';
});


const mostrarPrimeiroModal = ref(true);
const mostrarSegundoModal = ref(false);
const mostrarTerceiroModal = ref(false);

const nextSegundoCard = () => {
    mostrarPrimeiroModal.value = false;
    mostrarSegundoModal.value = true;
};

const nextTerceiroCard = () => {
    mostrarPrimeiroModal.value = false;
    mostrarSegundoModal.value = false;
    mostrarTerceiroModal.value = true;

    subtarefas.value.push({
        nome: nomeSubtarefa.value,
        descricao: descricaoSubtarefa.value,
    });
};

const newTask = async () => {
    try {
    
        const response = await axios.post('http://127.0.0.1:8000/api/criar-tarefa', {
            title: nomeTarefa.value,
            description: descricaoTarefa.value,
            due_date: dataVencimento.value
        });

        const taskId = response.data.tarefa.id

        console.log({
            title: nomeSubtarefa.value,
            id_task: taskId,
            description: descricaoSubtarefa.value,
        });

        await axios.post('http://127.0.0.1:8000/api/criar-subtarefa', {
            title: nomeSubtarefa.value,
            id_task: taskId,
            description: descricaoSubtarefa.value,
        });

        emit('close');

        setTimeout(() => {
            window.location.reload();
        }, 200);
    } catch (err) {

        if (err.response && err.response.data.errors) {
            console.log('Erro de validação:', err.response.data.errors);
        } else {
            console.log('Erro ao criar nova tarefa:', err);
        }
    }
};



</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #00000080;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content,
.modal-content-second {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    width: 678px;
    padding: 20px;
    gap: 10px;
    box-shadow: 0 4px 10px #0000004d;
}

.modal-content>input {
    font-size: 16px;
    font-weight: 400;
    color: #81858e;
    height: 40px;
    border: none;
}

#button-content {
    display: flex;
    align-items: end;
    justify-content: end;
    border-top: solid 1px rgba(229, 229, 229, 1);
    padding: 15px 0;
}

#input-date {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 200px;
    border: solid 1px #e5e5e5;
}
</style>
