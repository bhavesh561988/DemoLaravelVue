<template>
  <div>
    <h3 class="text-center">Orders</h3>
    <div class="container">
      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col" width="20%" class="text-center">#</th>
            <th scope="col" width="20%" class="text-center">Amount</th>
            <th scope="col" width="20%" class="text-center">Status</th>
            <th scope="col" width="20%" class="text-center">Order Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td class="text-center">{{ order.order_id }}</td>
            <td class="text-center">${{ order.amount }}</td>
            <td class="text-center">
              <select name="orderStatus" @change="updateStatus(order.id, order.status)" class="form-control" v-model="order.status">
                <option :value="status" v-for="(status, index) in statuses" :key="index">{{ status }}</option>
              </select>
            </td>
            <td class="text-center">{{ order.created_at }}</td>
            <td class="text-center" @click="detailProduct = order">
            <button
              class="btn btn-outline-primary btn-block"
              v-b-modal.product-detail-modal
            >
              View
            </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <b-modal
      id="product-detail-modal"
      size="xl"
      hide-footer
      :title="detailProduct.order_id"
      centered
    >
      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col" width="20%" class="text-center">Product</th>
            <th scope="col" idth="20%" class="text-center">Price</th>
            <th scope="col" width="45%" class="text-center">Qty</th>
            <th scope="col" width="20%" class="text-center">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="prod in detailProduct.order_items" :key="prod.id">
            <td class="text-center">
              <img
                :src="prod.product.image"
                alt="Product"
                height="50"
                width="50"
              /><br />{{ prod.product.name }}
            </td>
            <td class="text-center">${{ prod.price }}</td>
            <td class="text-center">{{ prod.qty }}</td>
            <td class="text-center">${{ prod.total }}</td>
          </tr>
          <tr>
            <td colspan="3" class="text-right"><b>Total</b></td>
            <td colspan="2" class="text-center">
              <b>${{ detailProduct.amount }}</b>
            </td>
          </tr>
        </tbody>
      </table>
    </b-modal>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      orders: [],
      detailProduct: "",
      statuses: ['placed','dispatch','delivered']
    };
  },
  created() {
    let url = `http://localhost:8000/api/orders`;
    this.axios.get(url).then((response) => {
      this.orders = response.data;
      console.log(this.orders);
    });
  },
  methods: {
    updateStatus(order_id, status)
    {
      let url = `http://localhost:8000/api/order/status/update`;
      let data = {
        order_id: order_id,
        status: status
      }
      this.axios.post(url,data).then((response) => {
         if(response.data.success === true){
           this.$toaster.success('Your status updated successfully!.');
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