<template>
  <div id="entrada-area">

    <h2>Entrada</h2>

    <div class="card" v-for="task in tasks" :key="task.id" @click.stop="openModal(task)">

      <header>
        <label class="custom-checkbox">
          <input type="checkbox" :checked="task.status === 'completed'" @change.stop="toggleStatus(task)" />
          <span class="checkmark"></span>
        </label>
        <h3>{{ task.title }}</h3>
      </header>

      <div id="description-container">
        <div id="description">
          <p>{{ task.description }}</p>
          <div :class="task.backgroundClass" id="due-date">
            <img src="../assets/images/calendario-icon.png" alt="">
            {{ task.due_date }}
          </div>
        </div>
        <div class="button-container">
          <button @click.stop="openUpdateModal(task)">
            <img src="../assets/images/lapis-icon.png" alt="">
          </button>
          <button @click.stop>
            <img src="../assets/images/calendario-icon.png" alt="">
          </button>
          <button @click.stop="deleteTask(task.id)">
            <img src="../assets/images/lixeira-icon.png" alt="">
          </button>
        </div>
      </div>

      <div id="subtarefas-container" v-if="task.subtarefas.length > 0">
        <div id="subtarefas" v-for="sub in task.subtarefas" :key="sub.id">
          <div id="description-sub">
            <label class="custom-checkbox">
              <input type="checkbox" :checked="sub.status === 'completed'" @change="toggleStatusSub(sub)" />
              <span class="checkmark"></span>
            </label>
            <h3>{{ sub.title }}</h3>
          </div>
          <div class="button-container">
            <button @click.stop="openUpdateModalSub(sub)">
              <img src="../assets/images/lapis-icon.png" alt="Editar">
            </button>
            <button @click.stop>
              <img src="../assets/images/calendario-icon.png" alt="Calendário">
            </button>
            <button @click.stop="deleteSubTask(sub.id)">
              <img src="../assets/images/lixeira-icon.png" alt="Excluir">
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="tasks.length === 0">Não há tarefas.</div>

    <div class="update-modal-overlay">
      <div class="modal-content">
        <h2>Editar Tarefa</h2>
        <input v-model="nomeTarefa" placeholder="Nome da tarefa" />
        <input v-model="descricaoTarefa" placeholder="Descrição" />
        <input id="date" type="date" v-model="dataVencimento" />
        <div class="button-container-modal">
          <Button text="Cancelar" id="light" @click="closeUpdateModal()"></Button>
          <Button text="Alterar tarefa" id="dark" @click="saveUpdatedTask()"></Button>
        </div>
      </div>
    </div>
    <div class="update-modal-overlay-sub">
      <div class="modal-content">
        <h2>Editar Subtarefa</h2>
        <input v-model="nomeSubtarefa" placeholder="Nome da subtarefa" />
        <input v-model="descricaoSubtarefa" placeholder="Descrição" />
        <input id="date" type="date" v-model="dataVencimentoSubtarefa" />
        <div class="button-container-modal">
          <Button text="Cancelar" id="light" @click="closeUpdateModalSub()"></Button>
          <Button text="Alterar subtarefa" id="dark" @click="updateSubTask(selectedTaskSub)"></Button>
        </div>
      </div>
    </div>

    <Modal v-if="modalVisible" :task="selectedTask" :isVisible="modalVisible" @close="closeModal" />
  </div>
</template>

<script>
import Modal from "@/components/Modal.vue";
import Button from "@/components/Button.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  components: {
    Modal,
    Button
  },
  setup() {
    const tasks = ref([]);
    const loading = ref(false);
    const error = ref(null);
    const modalVisible = ref(false);
    const selectedTask = ref(null);
    const isUpdateModalVisible = ref(false);
    const nomeTarefa = ref('');
    const descricaoTarefa = ref('');
    const dataVencimento = ref('');
    const selectedTaskSub = ref(null)
    const nomeSubtarefa = ref('');
    const descricaoSubtarefa = ref('');
    const dataVencimentoSubtarefa = ref('');

    const fetchTasks = async () => {
      loading.value = true;
      error.value = null;

      try {
        const response = await axios.get("http://127.0.0.1:8000/api/tarefas");
        console.log("Dados recebidos da API:", response.data);

        tasks.value = response.data.map(task => {
          const formattedDate = new Intl.DateTimeFormat('pt-BR').format(new Date(task.due_date));

          const taskDate = new Date(task.due_date);
          const today = new Date();
          today.setHours(0, 0, 0, 0);

          const isDueTodayOrLater = taskDate >= today;
          const backgroundClass = isDueTodayOrLater ? "due-today-or-later" : "due-past";

          return {
            ...task,
            due_date: formattedDate,
            backgroundClass,
            subtarefas: Array.isArray(task.subtarefas) ? task.subtarefas : []
          };
        }).reverse();
      } catch (err) {
        console.error("Erro ao buscar as tarefas:", err);
        error.value = "Erro ao buscar as tarefas";
      } finally {
        loading.value = false;
      }
    };

    const deleteTask = async (id) => {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/deletar-tarefa/${id}`);

        setTimeout(() => {
          window.location.reload();
        }, 200);

      } catch (err) {
        console.error("Erro ao deletar a tarefa:", err);
        error.value = "Erro ao deletar a tarefa";
      }
    }

    const updateTask = async (id) => {
      try {
        await axios.put(`http://127.0.0.1:8000/api/alterar-tarefa/${id}`, {
          title: nomeTarefa.value,
          description: descricaoTarefa.value,
          due_date: dataVencimento.value,
        });


        setTimeout(() => {
          window.location.reload();
        }, 200);

        closeUpdateModal();

      } catch (err) {
        console.error("Erro ao atualizar a tarefa:", err);
        error.value = "Erro ao atualizar a tarefa";
      }
    };

    const deleteSubTask = async (id) => {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/deletar-subtarefa/${id}`);

        setTimeout(() => {
          window.location.reload();
        }, 200);
      } catch (err) {
        console.error("Erro ao deletar a tarefa:", err);
        error.value = "Erro ao deletar a tarefa";
      }
    };


    const updateSubTask = async (id) => {
      try {
        await axios.put(`http://127.0.0.1:8000/api/alterar-subtarefa/${id}`, {
          title: nomeSubtarefa.value,
          description: descricaoSubtarefa.value,
          due_date: dataVencimentoSubtarefa.value,
        });

        setTimeout(() => {
          window.location.reload();
        }, 200);

        closeUpdateModalSub();
      } catch (err) {
        console.error("Erro ao atualizar a tarefa:", err);
        error.value = "Erro ao atualizar a tarefa";
      }
    };

    const openUpdateModalSub = (sub) => {
      selectedTaskSub.value = sub.id;
      nomeSubtarefa.value = sub.title;
      descricaoSubtarefa.value = sub.description;
      dataVencimentoSubtarefa.value = sub.due_date;
      const modal = document.querySelector('.update-modal-overlay-sub');
      if (modal) {
        modal.style.display = 'flex';
        isUpdateModalVisibleSub.value = true;
      }
    };

    const closeUpdateModalSub = () => {
      const modal = document.querySelector('.update-modal-overlay-sub');
      if (modal) {
        modal.style.display = 'none';
        isUpdateModalVisible.value = false;
      }
    };

    const toggleStatus = async (task) => {
      const newStatus = task.status === "completed" ? "pending" : "completed";
      try {
        await axios.put(`http://127.0.0.1:8000/api/alterar-status-tarefa/${task.id}`, {
          ...task,
          status: newStatus,
        });

        task.status = newStatus;

        setTimeout(() => {
          window.location.reload();
        }, 200);
        
      } catch (err) {
        console.error("Erro ao atualizar o status da tarefa:", err);
        error.value = "Erro ao atualizar o status da tarefa";
      }
    };

    const toggleStatusSub = async (sub) => {
      const newStatus = sub.status === "completed" ? "pending" : "completed";
      try {
        await axios.put(`http://127.0.0.1:8000/api/alterar-status-subtarefa/${sub.id}`, {
          ...sub,
          status: newStatus,
        });

        sub.status = newStatus;

        setTimeout(() => {
          window.location.reload();
        }, 200);

      } catch (err) {
        console.error("Erro ao atualizar o status da subtarefa:", err);
        error.value = "Erro ao atualizar o status da subtarefa";
      }
    };

    const openUpdateModal = (task) => {
      selectedTask.value = task;
      nomeTarefa.value = task.title;
      descricaoTarefa.value = task.description;
      dataVencimento.value = task.due_date;
      const modal = document.querySelector('.update-modal-overlay');
      if (modal) {
        modal.style.display = 'flex';
        isUpdateModalVisible.value = true;
      }
    };


    const closeUpdateModal = () => {
      const modal = document.querySelector('.update-modal-overlay');
      if (modal) {
        modal.style.display = 'none';
        isUpdateModalVisible.value = false;
      }
    };

    const openModal = (task) => {
      selectedTask.value = task;
      modalVisible.value = true;
    };

    const closeModal = () => {
      modalVisible.value = false;
    };

    const saveUpdatedTask = () => {
      if (selectedTask.value) {
        updateTask(selectedTask.value.id);
      }
    };

    onMounted(fetchTasks);

    return {
      tasks,
      loading,
      error,
      toggleStatus,
      toggleStatusSub,
      modalVisible,
      selectedTask,
      openModal,
      closeModal,
      openUpdateModal,
      closeUpdateModal,
      updateTask,
      saveUpdatedTask,
      nomeTarefa,
      descricaoTarefa,
      dataVencimento,
      isUpdateModalVisible,
      deleteTask,
      updateSubTask,
      openUpdateModalSub,
      closeUpdateModalSub,
      dataVencimentoSubtarefa,
      nomeSubtarefa,
      descricaoSubtarefa,
      selectedTaskSub,
      deleteSubTask

    };
  },
};
</script>

<style scoped>
#entrada-area {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 20px;
  position: relative;
}

h2 {
  margin-top: 50px;
  margin-bottom: 10px;
}

.card {
  display: flex;
  flex-direction: column;
  min-width: 678px;
  background: #ffffff;
  border: solid 1px #0000001f;
  gap: 10px;
  cursor: pointer;
}

.card header {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 15px 20px 5px 20px;
}

.custom-checkbox input {
  display: none;
}

.custom-checkbox .checkmark {
  width: 20px;
  height: 20px;
  border: 2px solid #ccc;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  cursor: pointer;
}

.custom-checkbox input:checked+.checkmark {
  background-color: #000000;
  border-color: #000000;
}

.custom-checkbox input:checked+.checkmark::after {
  content: "";
  position: absolute;
  width: 3px;
  height: 7px;
  border: solid white;
  border-width: 0 1.5px 1px 0;
  transform: rotate(45deg);
}

#description-container {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  padding: 0px 0px 0px 60px;
}

#description-container>#description {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

#description-sub {
  display: flex;
  gap: 20px;
}

.button-container {
  display: flex;
  align-items: center;
  padding-right: 30px;
  gap: 30px;
  opacity: 0;
  transition: 0.2s;
}

.button-container>button {
  border: none;
  background-color: transparent;
  cursor: pointer;
}


#subtarefas-container {
  display: flex;
  gap: 20px;
  border-top: solid 1px #0000001f;
  padding: 20px 0px 20px 60px;

}

#description-container:hover>.button-container {
  opacity: 1;
}

#subtarefas:hover>.button-container {
  opacity: 1;
}

#subtarefas {
  display: flex;
  justify-content: space-between;
  width: 100%;
}



#due-date {
  display: flex;
  align-items: center;
  width: 116px;
  font-size: 14px;
  padding: 4px 7px;
  gap: 10px;
}

.due-today-or-later {
  background-color: rgba(0, 148, 136, 0.1);
  color: rgba(0, 148, 136, 1);
}

.due-past {
  background-color: rgba(211, 20, 8, 0.1);
  color: rgba(211, 20, 8, 1);
}

.update-modal-overlay {
  display: none;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
}

.modal-content {
  display: flex;
  flex-direction: column;
  background: #ffffff;
  gap: 10px;
  padding: 20px;
  width: 678px;
}

.modal-content>input {
  height: 50px;
  border: none;
  font-size: 16px;

}

#date {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 150px;
  background-color: rgba(229, 229, 229, 1);
}

.button-container-modal {
  display: flex;
  align-items: center;
  justify-content: end;
  padding: 20px;
  border-top: solid 1px rgba(229, 229, 229, 1);
}

.update-modal-overlay-sub {
  display: none;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
}
</style>
