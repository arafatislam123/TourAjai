<template>
  <AdminLayout>
    <div class="space-y-6">
      <h1 class="text-3xl font-bold">Manage Bookings</h1>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow p-4">
        <div class="grid md:grid-cols-3 gap-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search bookings..."
            class="px-4 py-2 border rounded-lg"
            @input="search"
          />
          <select v-model="statusFilter" class="px-4 py-2 border rounded-lg" @change="search">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
            <option value="completed">Completed</option>
          </select>
        </div>
      </div>

      <!-- Bookings Table -->
      <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking #</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tour</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="booking in bookings.data" :key="booking.id">
              <td class="px-6 py-4 text-sm font-medium">{{ booking.booking_number }}</td>
              <td class="px-6 py-4 text-sm">{{ booking.customer_name }}</td>
              <td class="px-6 py-4 text-sm">{{ booking.tour?.title }}</td>
              <td class="px-6 py-4 text-sm font-semibold">৳{{ booking.total_amount }}</td>
              <td class="px-6 py-4">
                <span
                  :class="[
                    'px-2 py-1 text-xs rounded-full',
                    booking.status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                  ]"
                >
                  {{ booking.status }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm">{{ formatDate(booking.created_at) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  bookings: Object,
  filters: Object
});

const searchQuery = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');

const search = () => {
  router.get('/admin/bookings', {
    search: searchQuery.value,
    status: statusFilter.value
  }, { preserveState: true });
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  });
};
</script>
