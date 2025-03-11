<template>
  <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">
      <header>
          <div id="due_date" ref="dueDateRef">{{ task.due_date }}</div>
        <div>
          <img src="../assets/images/menu-modal.png" alt="">
          <button class="close-btn" @click="closeModal">
            <img src="../assets/images/close-modal.png" alt="">
          </button>
        </div>
      </header>
      <div id="main-body">
        <div id="left-content">
          <div id="main-content">
            <label class="custom-checkbox">
              <input type="checkbox" :checked="task.status === 'completed'" @change="toggleStatus(task)" />
              <span class="checkmark"></span>
            </label>
            <h2>{{ task.title }}</h2>
          </div>
          <div id="sub-content" v-if="task.subtarefas.length > 0">
            <p>{{ task.description }}</p>
            <h2 id="sub-title">Subtarefas</h2>
            <ul id="subtarefas">
              <label class="custom-checkbox">
                <input type="checkbox" :checked="task.status === 'completed'" @change="toggleStatus(task)" />
                <span class="checkmark"></span>
              </label>
              <li v-for="sub in task.subtarefas" :key="sub.id">{{ sub.title }}</li>
            </ul>
          </div>
        </div>
        <div id="right-content">
          <div>
            <h3>Criado em</h3>
            <div class="container">
              <img src="../assets/images/calendario-icon.png" alt="">
              <p ref="createdRef">{{ task.created_at }}</p>
            </div>
          </div>
          <div>
            <h3>Data de vencimento</h3>
            <div class="container">
              <img src="../assets/images/calendario-icon.png" alt="">
              <p ref="dataRef">{{ task.due_date }}</p>
            </div>
          </div>
          <div>
            <h3>Modificado em</h3>
            <div class="container">
              <img src="../assets/images/calendario-icon.png" alt="">
              <p ref="updatedRef">{{ task.updated_at }}</p>
            </div>
          </div>
          <div>
            <h3>ID da tarefa</h3>
            <p>{{ task.id }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
export default {
  props: {
    task: Object,
    isVisible: Boolean,
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
  },

  setup(props) {
    const dueDateRef = ref(null);
    const dataRef = ref(null);
    const createdRef = ref(null);
    const updatedRef = ref(null);

    const day = new Date().getDate();
    const month = new Date().getMonth() + 1;
    const year = new Date().getFullYear();
    const currentDate = new Date(year, month - 1, day).getDate();

    const createdDate = new Date(props.task.created_at.split('/').reverse().join('-'));
    const createdDay = createdDate.getDate();
    const createdMonth = createdDate.getMonth();
    const createdYear = createdDate.getFullYear();
    const createdHours = createdDate.getHours();
    const createdMinutes = createdDate.getMinutes();
    

    const updatedDate = new Date(props.task.updated_at.split('/').reverse().join('-'));
    const updatedDay = updatedDate.getDate();
    const updatedMonth = updatedDate.getMonth();
    const updatedYear = updatedDate.getFullYear();
    const updatedHours = updatedDate.getHours();
    const updatedMinutes = updatedDate.getMinutes();


    onMounted(() => {
      if (!props.task || !props.task.due_date) return;

      const dueDate = new Date(props.task.due_date.split('/').reverse().join('-')).getDate();

      createdRef.value.innerHTML = `${createdDay}/${createdMonth + 1}/${createdYear} às ${createdHours}:${createdMinutes}`;

      updatedRef.value.innerHTML = `${updatedDay}/${updatedMonth + 1}/${updatedYear} às ${updatedHours}:${updatedMinutes}`;

      

      if (dueDate + 1 >= currentDate) {
        if (dueDateRef.value) {
          dueDateRef.value.style.backgroundColor = 'rgba(0, 148, 136, 0.1)';
          dueDateRef.value.style.color = 'rgba(0, 148, 136, 1)';
          dataRef.value.style.color = 'rgba(0, 148, 136, 1)';
          dueDateRef.value.innerHTML = 'No prazo';
          
        }
      } else {
        if (dueDateRef.value) {
          dueDateRef.value.style.backgroundColor = 'rgba(211, 20, 8, 0.1)';
          dueDateRef.value.style.color = 'rgba(211, 20, 8, 1)';
          dataRef.value.style.color = 'rgba(211, 20, 8, 1)';
          dueDateRef.value.innerHTML = 'Atrasado';
        }
      }
    });

    return { dueDateRef, dataRef, createdRef, updatedRef };
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
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  width: 100%;
  height: 100%;
  position: relative;
}

h2 {
  font-size: 18px;
  font-weight: 600;
}

p, li {
  font-size: 14px;
  font-weight: 400;
}


.modal-content header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  padding: 20px 30px;
  border-bottom: solid 1px #e5e5e5;
}

.modal-content header div {
  display: flex;
  align-items: center;
  gap: 35px;
}


#main-content {
  display: flex;
  align-items: center;
  height: 100%;
  padding-top: 30px;
  padding-left: 30px;
  gap: 20px;
}



#sub-content {
  padding-left: 70px;
}

#sub-title {
  padding: 38px 0 15px 0;
}

#subtarefas {
  display: flex;
  align-items: center;
  gap: 20px;
  list-style: none;
  border-top: solid 1px #e5e5e5;
  padding-top: 20px;

}


.custom-checkbox input {
  display: none;
}

.custom-checkbox input:checked+.checkmark {
  background-color: #000;
  border-color: #000;
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


.close-btn {
  font-size: 20px;
  background: none;
  border: none;
  cursor: pointer;
}


#main-body {
  display: flex;
  align-items: start;
  justify-content: space-between;
  height: 100dvh;
}

#left-content {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 100%;
  padding-right: 30px;

}

#right-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: start;
  width: 246px;
  height: 100%;
  gap: 40px;
  background-color: #f7f7f7;
  padding: 30px;
}

#right-content > div {
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: center;
  width: 100%;
  gap: 10px;
  
}

#right-content > div > h3 {
  font-size: 14px;
  font-weight: 400;
  color: rgba(129, 133, 142, 1);
}

#right-content  p {
  font-size: 14px;
  font-weight: 600;
  color: rgba(0, 0, 0, 1);
}

#due_date {
  display: flex;
  padding: 10px;
}

.container {
  display: flex;
  gap: 10px;
}
</style>