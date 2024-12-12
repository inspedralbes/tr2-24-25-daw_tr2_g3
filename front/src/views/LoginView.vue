<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container class="pt-0-important">
      <q-page>
        <div class="row" style="height: 100vh">
          <div class="col-12 flex content-center justify-center">
            <q-card class="q-ma-xl">
              <div class="row">
                <div class="col-0 col-sm-5 bg-primary rounded-left-borders xs-hide">
                  <div class="row q-ml-sm q-mt-sm">
                    <div class="col-12 fredoka text-subtitle1">
                      <router-link class="text-white" style="text-decoration: none" to="/">System Name
                      </router-link>
                    </div>
                  </div>
                  <div class="row full-width q-px-xl q-pb-xl full-height flex flex-center">
                    <div class="">
                      <div class="text-h4 text-uppercase text-white fredoka" style="min-width: 220px">Bem vindo!</div>
                      <div class="text-white q-my-sm text-subtitle1">Informe suas credenciais para realizar login!</div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-7">
                  <div class="row q-pa-sm-sm q-pa-md">
                    <div class="col-12">
                      <q-card-section>
                        <div class="q-mb-xl">
                          <div class="flex justify-center">
                            <div class="text-h4 text-uppercase q-my-none text-weight-bold text-primary fredoka">Login</div>
                          </div>
                        </div>
                        <q-form class="q-gutter-md">
                          <q-input label="Nome de usuário"
                                   name="username"/>
                          <q-input label="Senha"
                                   name="password" type="password"/>
                          <div>
                            <q-btn class="full-width fredoka" color="primary" label="Entrar" rounded
                                   type="submit"></q-btn>
                            <div class="q-mt-lg">
                              <div class="q-mt-sm">
                                Ainda não possui uma conta?
                                <router-link class="text-primary" to="/login">Cadastrar-se</router-link>
                              </div>
                              <div class="q-mt-sm">
                                Esqueceu a senha? Clique
                                <router-link class="text-primary" to="/">aqui!</router-link>
                              </div>
                            </div>
                          </div>
                        </q-form>
                      </q-card-section>
                    </div>
                  </div>
                </div>
              </div>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>


</script>
<style>
.bg-auth {
  backgroud-color: #F0F4F3;
  background-image: url("src/assets/login/bg-auth.png");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
</style>
