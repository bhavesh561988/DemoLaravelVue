<template>
  <div>
    <h3 class="text-center">My Orders</h3>
    <div class="container">
      <table class="table mt-4">
        <thead>
          <tr>
            <th scope="col" width="20%" class="text-center">#</th>
            <th scope="col" width="20%" class="text-center">Amount</th>
            <th scope="col" width="20%" class="text-center">Status</th>
            <th scope="col" width="20%" class="text-center">Order Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td class="text-center">{{ order.order_id }}</td>
            <td class="text-center">${{ order.amount }}</td>
            <td class="text-center">{{ order.status }}</td>
            <td class="text-center">{{ order.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      orders: [],
    };
  },
  created() {
    let url = `http://localhost:8000/api/orders`;
    this.axios.get(url).then((response) => {
      this.orders = response.data;
      console.log(this.orders);
    });
  },
  methods: {},
};
</script>