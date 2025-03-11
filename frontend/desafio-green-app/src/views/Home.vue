<template>
  <section id="home-area">
    <header>
      <img src="../assets/images/logo.png" alt="logo do projeto">
      <div id="icons-content">
        <button class="button-criar-tarefa-header" @click="openModal()">
          <img src="../assets/images/btn-nova-tarefa-header.png" alt="">
          Criar tarefa
        </button>
        <img src="../assets/images/Vector (9).png" alt="">
        <img src="../assets//images/sino-icon.png" alt="">
        <div id="foto-perfil">L</div>
      </div>
    </header>
    <section id="main-content">
      <div id="menu">
        <ul>
          <li>
            <img src="../assets/images/entrada.png" alt="icone entrada.">
            <router-link to="entrada">Entrada</router-link>
          </li>
          <li>
            <img src="../assets/images/tarefas.png" alt="icone tarefas do dia.">
            <router-link to="tarefas">Tarefas de hoje</router-link>
          </li>
          <li>
            <img src="../assets/images/vencidos.png" alt="icone tarefas vencidas.">
            <router-link to="vencidos">Vencidos</router-link>
          </li>
        </ul>
      </div>
      <div id="tela">
        <RouterView />
        <div id="button-content">
          <button class="button-criar-tarefa" @click="openModal()">
            <img src="../assets/images/botao-nova-tarefa-dark.png" alt="">
            Criar tarefa
          </button>
        </div>
      </div>
    </section>
    <ModalNovaTarefa v-if="modalVisible" :isVisible="modalVisible" @close="closeModal" />

  </section>
</template>

<script setup>
import { ref } from 'vue';
import ModalNovaTarefa from '@/components/ModalNovaTarefa.vue';

const modalVisible = ref(false);

const openModal = () => {
  modalVisible.value = true;
}

const closeModal = () => {
  modalVisible.value = false;
}
</script>


<style scoped>
#home-area {
  display: grid;
  grid-template-rows: 9dvh 91dvh;
  width: 100dvw;
  height: 100dvh;
  padding: 0;
  margin: 0;

  & header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0px 30px 0 30px;
    width: 100%;
    background-color: #000000;

    & #icons-content {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 45px;
    }
  }

  & #main-content {
    display: flex;
    flex-direction: row;
    width: 100dvw;
    height: 100%;


    & #menu {
      display: flex;
      align-items: start;
      justify-content: center;
      width: 293px;
      background-color: #f5f5f5;
      padding: 50px 30px 50px 30px;

      & ul {
        display: flex;
        flex-direction: column;
        gap: 30px;
        list-style: none;


        & li {
          display: flex;
          align-items: center;
          gap: 20px;


          & a {
            font-size: 15px;
            font-weight: 600;
            color: #000000;
          }
        }
      }
    }

    & #tela {
      display: flex;
      flex-direction: column;
      justify-content: start;
      width: 90%;
      padding: 20px 150px 20px 150px;
      overflow-y: auto;
    }
  }
}

#button-content {
  border: solid 1px #e5e5e5;
  padding: 15px 25px 15px 25px;
}

.button-criar-tarefa {
  display: flex;
  align-items: center;
  border: none;
  gap: 10px;
  background-color: transparent;
  cursor: pointer;
  font-size: 15px;
  font-weight: 400;
  color: #81858e;
}

.button-criar-tarefa-header {
  display: flex;
  align-items: center;
  border: none;
  gap: 10px;
  background-color: transparent;
  cursor: pointer;
  font-size: 15px;
  font-weight: 400;
  color: #ffffff;
}

#foto-perfil {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  border-radius: 100%;
  color: #ffffff;
  background-color: #009488;
}
</style>