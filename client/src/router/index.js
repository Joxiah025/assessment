import Vue from "vue";
import VueRouter from "vue-router";
import Board from "../views/Board.vue";
import NotFound from "../views/NotFound.vue";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Board",
    component: Board,
  },
  {
    path: "*",
    name: "NotFound",
    component: NotFound,
  }
  // {
  //   path: "/about",
  //   name: "About",
  //   component: () =>
  //     import(/* webpackChunkName: "about" */ "../views/About.vue"),
  // },
];

const router = new VueRouter({
  mode: "history",
  routes,
});

export default router;
