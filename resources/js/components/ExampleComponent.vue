<template>
  <b-container fluid>
    <div class="w-100 row mb-3" style="height: 50px;">
      <div class="col-6 d-flex align-items-center "><span class="font-weight-bold">Cadastro de Produtos</span></div>
      <div class="col-6 d-flex  align-items-center flex-row-reverse "><b-button variant="primary"
          @click="infoStore($event.target)">Add Product</b-button>
      </div>
    </div>
    <div>
      <b-table id="my-table" striped hover :items="items" :fields="fields" bordered :per-page="perPage"
        :current-page="currentPage" responsive>
        <template #cell(actions)="row">

          <b-button size="sm" class="mr-2 mb-2 mb-sm-0" variant="info" @click="info(row.item, $event.target)">
            Edit
          </b-button>


          <b-button size="sm" class="mr-2" variant="danger" @click="infoDelete(row.item, $event.target)">
            Delete
          </b-button>
        </template></b-table>
      <div class="d-flex  align-items-center flex-row-reverse">
        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage"
          aria-controls="my-table"></b-pagination>
      </div>


    </div>
    <!-- update model -->
    <b-container fluid>
      <b-modal :id="infoModal.id" :title="infoModal.title" @hide="resetInfoModal" ref="update-modal" hide-footer>
        <b-form @submit.prevent="onSubmit" :value="csrf">
          <b-form-group id="input-group-1" label="Name:" label-for="input-1">
            <b-form-input id="input-1" v-model="form.name" placeholder="Enter name" required></b-form-input>
          </b-form-group>
          <b-form-group id="input-group-2" label="Description:" label-for="input-2">
            <b-form-input id="input-2" v-model="form.description" placeholder="Enter description"></b-form-input>
          </b-form-group>
          <b-form-group id="input-group-3" label="Price:" label-for="input-3">
            <b-form-input id="input-3" v-model="form.price" placeholder="Enter price" required></b-form-input>
          </b-form-group>
          <b-form-group id="input-group-4" label="Quantity:" label-for="input-4">
            <b-form-input id="input-4" v-model="form.quantity" placeholder="Enter quantity" required></b-form-input>
          </b-form-group>
          <b-button type="submit" variant="primary">Submit</b-button>
        </b-form>
      </b-modal>
    </b-container>

    <!-- delete modal -->
    <b-modal :id="deleteModal.id" :title="deleteModal.title" @hide="resetDeleteModal" ref="delete-modal" hide-footer>
      <b-form @submit.prevent="onDelete">
        <div>Confirm to delete the product</div>
        <div class="row d-flex flex-row-reverse px-2">
          <b-button type="submit" variant="danger" class="mt-4">Delete</b-button>
        </div>
      </b-form>
    </b-modal>


  </b-container>
</template>


<script>
export default {
  data() {
    return {
      perPage: 5,
      currentPage: 1,
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      fields: ['id', 'name', 'description', 'price', 'quantity', 'actions'],
      items: [],
      form: {
        name: '',
        description: '',
        price: '',
        quantity: ''
      },
      id: null,
      infoModal: {
        id: 'info-modal',
        title: '',
      },
      deleteModal: {
        id: 'delete-modal',
        title: '',
      }
    }
  },
  computed: {
    rows() {
      return this.items.length
    }
  },
  mounted() {
    this.fetchDataFromAPI();
  },
  methods: {
    //api
    fetchDataFromAPI() {
      axios
        .get('http://localhost/api/index')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    onSubmit() {
      if (this.id != null) {
        axios
          .post('http://localhost/api/update/' + this.id, this.form)
          .then(response => {
            this.resetInfoModal();
            this.$refs['update-modal'].hide()
            this.fetchDataFromAPI();

          })
          .catch(error => {
            console.log(error);
          });
      }
      else {
        axios
          .post('http://localhost/api/register/', this.form)
          .then(response => {
            this.resetInfoModal();
            this.$refs['update-modal'].hide()
            this.fetchDataFromAPI();

          })
          .catch(error => {
            console.log(error);
          });
      }

    },
    onDelete() {
      axios
        .delete('http://localhost/api/delete/' + this.id)
        .then(response => {
          this.fetchDataFromAPI();
          this.$refs['delete-modal'].hide()

        })
        .catch(error => {
          console.log(error);
        });
    },
    // -----
    info(item, button) {
      this.infoModal.title = item.name;
      this.id = item.id;
      this.form.name = item.name;
      this.form.description = item.description;
      this.form.price = item.price;
      this.form.quantity = item.quantity;
      this.$root.$emit('bv::show::modal', this.infoModal.id, button)
    },
    infoStore(button) {
      this.infoModal.title = "Add a product";
      this.$root.$emit('bv::show::modal', this.infoModal.id, button)
    },
    infoDelete(item, button) {
      this.deleteModal.title = item.id + ' / ' + item.name;
      this.id = item.id;
      this.$root.$emit('bv::show::modal', this.deleteModal.id, button)
    },
    resetInfoModal() {
      this.infoModal.title = ''
      this.id = null;
      this.form.name = '';
      this.form.description = '';
      this.form.price = '';
      this.form.quantity = '';
    },
    resetDeleteModal() {
      this.deleteModal.title = '';
    },

  },


}
</script>
