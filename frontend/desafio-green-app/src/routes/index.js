import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Cadastro from "../views/Cadastro.vue";
import Entrada from "../views/Entrada.vue";
import Vencidos from "../views/Vencidos.vue";
import Tarefas from "../views/Tarefas.vue";

const routes = [
    { path: '/', component: Login },
    { path: '/cadastro', component: Cadastro },
    { 
        path: '/home', 
        component: Home,
        children: [
            { path: '/entrada', component: Entrada },
            { path: '/tarefas', component: Tarefas },
            { path: '/vencidos', component: Vencidos }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
