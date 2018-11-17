<template>
<div>
    <div v-if="successMessage!=null" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ successMessage }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <a class="btn btn-primary btn-xs" href="#" @click="showCreateActorForm">
                        Crear Actor
                    </a>
<div class="table-responsive">
    <div v-if="actores.length > 0">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th># Películas</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="actor in actores">
                    <td>{{actor.nombres}}</td>
                    <td>{{actor.apellidos}}</td>
                    <td>{{actor.peliculas_count}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else style="text-align:center">
        <h1>
            <i class="fa fa-circle-o-notch fa-spin"></i> Cargando
        </h1>
    </div>
</div>
   <!-- Create Actor Modal -->
        <div class="modal fade" id="modal-create-actor" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Crear Actor
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Create Actor Form -->
                        <form role="form">
                            <!-- Nombres -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nombres</label>

                                <div class="col-md-9">
                                    <input id="create-actor-name" type="text" class="form-control"
                                               name="nombres" @keyup.enter="store" v-model="createForm.nombres">
                                </div>
                            </div>

                            <!-- Apellidos-->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Apellidos</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="apellidos"
                                                    @keyup.enter="store" v-model="createForm.apellidos">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div> 
</div>

</template>
<script>
export default {
  data() {
    return {
      actores: [],
      createForm: {
        errors: [],
        nombres: "",
        apellidos: ""
      },
      successMessage: null
    };
  },
  mounted() {
    this.prepareComponent();
  },
  methods: {
    prepareComponent() {
      this.getActores();

      $("#modal-create-actor").on("shown.bs.modal", () => {
        $("#create-actor-name").focus();
      });
    },
    getActores() {
      axios.get("/api/actores").then(response => {
        this.actores = response.data;
      });
    },
    showCreateActorForm() {
      $("#modal-create-actor").modal("show");
    },
    store() {
      this.persistActor(
        "post",
        "/api/actores",
        this.createForm,
        "#modal-create-actor"
      );
    },
    persistActor(method, uri, form, modal) {
      form.errors = [];
      this.successMessage = null;

      axios[method](uri, form)
        .then(response => {
          this.getActores();

          form.nombres = "";
          form.apellidos = "";
          form.errors = [];

          $(modal).modal("hide");
          this.successMessage = "Actor registrado";
        })
        .catch(error => {
          if (typeof error.response.data === "object") {
            form.errors = _.flatten(_.toArray(error.response.data.errors));
          } else {
            form.errors = ["Something went wrong. Please try again."];
          }
        });
    }
  }
};
</script>
