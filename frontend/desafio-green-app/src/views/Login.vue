<template>
  <section id="login-container" class="hover">
    <Banner />
    <form action="">
      <h1>Login</h1>

      <Input label="Endereço de e-mail" id="email" type="email" placeholder="email@mail.com" />

      <Input label="Senha de acesso" id="password" type="password" placeholder="*******" />

      <div id="button-container">
        <router-link to="/cadastro">Não tenho conta</router-link>
        <router-link to="/home">
          <Button text="Acessar" id="dark"></Button>
        </router-link>
      </div>
    </form>
  </section>
</template>

<style scoped>
#login-container {
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
      color: #000000;
    }

  }

  & #button-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-top: 20px;
  }
}
</style>

<script setup>
import Banner from '@/components/Banner.vue';
import Input from '@/components/Input.vue';
import Button from '@/components/Button.vue';

</script>
