<template>
  <div class="d-flex">
    <div class="col-md-8">
      <div class="container">
        <hr />
      </div>

      <div class="container">
        <div class="row">
          <div
            class="col-md-4 mb-3"
            v-for="product in products"
            :key="product.id"
          >
            <div class="card" @click="detailProduct = product">
              <a href="#">
                <img
                  :src="product.image"
                  class="card-img-top"
                  alt="Product"
                  height="150"
                  
                />
              </a>
              <div class="card-body px-2 pb-2 pt-1">
                <div class="d-flex justify-content-between">
                  <div >
                    <p class="h4 text-primary">${{ product.price }}</p>
                  </div>
                </div>
                <p class="mb-0" >
                  <strong>
                    <a href="#" class="text-secondary">{{ product.name }}</a>
                  </strong>
                </p>
                <div class="d-flex justify-content-between">
                  <div class="col px-0"></div>
                  <div class="ml-2">
                    <button
                      class="btn btn-outline-primary btn-block"
                      v-b-modal.product-modal
                    >
                      View
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <hr />
      </div>
      <Pagination
        v-model="page"
        :records="totalRecords"
        :perPage="perPage"
        @paginate="productData()"
      />
    </div>
    <div
      class="col-md-4"
      v-if="!isLoading && selectedProduct.length > 0"
    >
      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col" width="20%" class="text-center">Product</th>
            <th scope="col" idth="20%" class="text-center">Price</th>
            <th scope="col" width="45%" class="text-center">Qty</th>
            <th scope="col" width="20%" class="text-center">Total</th>
            <th scope="col" width="5%"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="prod in selectedProduct" :key="prod.id">
            <td>
              <img
                :src="prod.image"
                alt="Product"
                height="50"
                width="50"
              /><br />{{ prod.name }}
            </td>
            <td>${{ prod.price }}</td>
            <td>
              <div class="d-flex">
                <button
                  class="btn btn-primary"
                  @click="changeQty(prod, 'minus')"
                >
                  -
                </button>
                <span class="ml-2 mr-2 mt-2">{{ prod.qty }}</span>
                <button class="btn btn-primary" @click="changeQty(prod, 'add')">
                  +
                </button>
              </div>
            </td>
            <td>${{ prod.total }}</td>
            <td>
              <button class="btn btn-danger" @click="removeCart(prod)">
                X
              </button>
            </td>
          </tr>
          <tr>
            <td colspan="3"><b>Total</b></td>
            <td colspan="2">
              <b>${{ totalAmount }}</b>
            </td>
          </tr>
          <tr>
            <td colspan="5">
               <button class="btn btn-success" @click="orderPlaced()">
                 Submit Order
              </button>
            </td>    
          </tr>
        </tbody>
      </table>
    </div>
    <b-modal
      id="product-modal"
      size="lg"
      hide-footer
      :title="detailProduct.name"
      centered
    >
      <div class="container-fluid d-flex">
        <img :src="detailProduct.image" />
        <div class="ml-5">
          <b>Price:</b> ${{ detailProduct.price }}
          <p class="text-justify">{{ detailProduct.description }}</p>
        </div>
      </div>
      <div class="d-flex justify-content-between">
        <div class="col px-0"></div>
        <div class="ml-2">
          <button
            class="btn btn-outline-primary btn-block"
            @click="addCart(detailProduct)"
          >
            Add Cart
          </button>
        </div>
      </div>
    </b-modal>
  </div>
</template>
 
<script>
import Pagination from "vue-pagination-2";

export default {
  data() {
    return {
      products: [],
      selectedProduct: [],
      isLoading: false,
      page: 1,
      totalRecords: 0,
      perPage: 6,
      totalAmount: 0,
      detailProduct: "",
    };
  },
  components: {
    Pagination,
  },
  created() {
    // const username = 'ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0';
    // const password = 'cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71';

    // const token = Buffer.from(`${username}:${password}`, 'utf8').toString('base64')
    // this.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

    // this.axios
    //     .get('https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products', {headers: {
    //         'Authorization': `Basic ${token}`, 'Accept': '*/*'}
    //     })
    //     .then(response => {
    //         this.products = response.data;
    //     });

    this.productData();
    let cartData = localStorage.getItem("cart");
    this.selectedProduct = JSON.parse(cartData);
    this.TotalCartAmount();
  },
  methods: {
    productData() {
      let url = `http://localhost:8000/api/products?page=${this.page}`;
      this.axios.get(url).then((response) => {
        const data = response.data;
        this.products = data.data;
        this.page = data.current_page;
        this.totalRecords = data.total;
      });
    },
    addCart(product) {
      if (this.selectedProduct.filter((e) => e.id === product.id) == 0) {
        product.qty = 1;
        product.total = product.price;
        this.selectedProduct.push(product);
        this.storeLocal();
        this.TotalCartAmount();
        this.$toaster.success('Add cart successfully!.');
      }
    },
    removeCart(product) {
      this.selectedProduct.splice(
        this.selectedProduct.findIndex((a) => a.id === product.id),
        1
      );
      this.TotalCartAmount();
      this.storeLocal();
      this.$toaster.info('Remove from cart successfuly!.')
    },
    storeLocal() {
      localStorage.removeItem("cart");
      localStorage.setItem("cart", JSON.stringify(this.selectedProduct));
    },


    changeQty(product, action) {
      this.isLoading = true;
      let index = this.selectedProduct.findIndex((a) => a.id === product.id);
      if (action === "add") {
        this.selectedProduct[index].qty = parseFloat(product.qty) + 1;
        this.selectedProduct[index].total = (
          parseFloat(product.qty) * parseFloat(product.price)
        ).toFixed(2);
      }
      if (action === "minus" && this.selectedProduct[index].qty != 1) {
        this.selectedProduct[index].qty = parseFloat(product.qty) - 1;
        this.selectedProduct[index].total = (
          parseFloat(product.qty) * parseFloat(product.price)
        ).toFixed(2);
      }
      this.storeLocal();
      this.TotalCartAmount();
      this.isLoading = false;
    },


    TotalCartAmount() {
      this.isLoading = true;
      this.totalAmount = 0;
      this.selectedProduct.forEach((element) => {
        this.totalAmount = (
          parseFloat(this.totalAmount) + parseFloat(element.total)
        ).toFixed(2);
      });
      this.isLoading = false;
    },
    orderPlaced() {
      let url = `http://localhost:8000/api/order/placed`;
      let data = {
        products: this.selectedProduct,
        totalAmount: this.totalAmount
      }
      this.axios.post(url,data).then((response) => {
         if(response.data.success === true){
           this.$toaster.success('Your order placed successfully!.');
           this.selectedProduct = [];
           this.storeLocal();
         }else{
           this.$toaster.error('Something went wrong plese tr again!.');
         }
      });
    }
  },
};
</script>
<style scoped>
</style>
