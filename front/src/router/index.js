import Vue from 'vue'
import VueRouter from 'vue-router'

import DashboardView from '../components/views/DashboardView.vue'
import LoginForm from '../authentication/LoginForm.vue'
import UserView from '../components/views/userView.vue'
import StudentView from '../components/views/StudentView.vue'
import DiscipleView from '../components/views/DiscipleView.vue'
import PermisionView from '../components/views/PermisionView.vue'
import PageNotFound from '../components/views/notFound.vue'
import StudentDetailView from '../components/views/StudentDetailView.vue'


Vue.use(VueRouter)

const routes = [{
    path: '/',
    component: DashboardView,
    meta: {
      needLogin: true,
    }
  },
  {
    path: '/login',
    component: LoginForm
  },
  {
    path: '/studentDetail/:studentId',
    component: StudentDetailView,
    meta: {
      needLogin: true
    },
    props: true
  },
  {
    path: '/user',
    component: UserView,
    meta: {
      needLogin: true,
      needAdmin: true
    }
  },
  {
    path: '/student',
    component: StudentView,
    meta: {
      needLogin: true,
      needAdmin: true,
      needSpecialUser: true
    }
  },
  {
    path: '/discipline',
    component: DiscipleView,
    meta: {
      needLogin: true,
      needAdmin: true
    }
  },
  {
    path: '/permision',
    component: PermisionView,
    meta: {
      needLogin: true,
      needAdmin: true
    }
  },
  {
    path: '/dashboard',
    component: DashboardView,
    meta: {
      needLogin: true,
      needAdmin: true
    }
  },
  {
    path: '/*',
    component: PageNotFound,
  },
]

let authenticationGuard = (to, from, next) => {
  let needLogin = to.meta.needLogin;
  if (needLogin) {
    if (!localStorage.userId) {
      next("/login")
    } else {
      if (to.path === "/login") {
        next("/");
      } else {
        next();
      }
    }

  } else {
    if (localStorage.userId) {
      if (to.path === "/login") {
        next("/");
      }
    }
  }
  next()
}


const router = new VueRouter({
  base: process.env.BASE_URL,
  routes
})

router.beforeEach(authenticationGuard);

export default router