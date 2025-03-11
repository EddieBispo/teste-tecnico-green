<template>
  <section id="cadastro-container">
    <form action="">
      <h1>Inscreva-se</h1>
      <Input label="Nome completo" id="email" type="email" placeholder="email@mail.com.br" />

      <Input label="Endereço de e-mail" id="comfirm-email" type="email" placeholder="email@mail.com.br" />

      <Input label="Senha de acesso" id="password" type="password" placeholder="*******" />

      <div id="button-container">
        <router-link id="link" to="/">Já tenho conta</router-link>
        <Button text="Cadastrar" id="dark"></Button>
      </div>
    </form>
    <Banner />
  </section>
</template>

<style scoped>
#cadastro-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  width: 1280px;
  padding: 30px;
  gap: 30px;
  box-shadow: 0 0 10px #00000027;


  & form {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 100%;
    gap: 20px;


    & h1 {
      font-size: 27px;
      font-weight: 800;
      line-height: 48.6px;
      color: black;
    }

    & #button-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      margin-top: 20px;

      

    }

  }
}
</style>

<script setup>
import Banner from '@/components/Banner.vue';
import Input from '@/components/Input.vue';
import Button from '@/components/Button.vue';
</script>