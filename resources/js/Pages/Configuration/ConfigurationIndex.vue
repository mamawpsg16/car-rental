<script setup>
/** IMPORTS */
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import ContentLayout from '@/Layouts/ContentLayout.vue';
import { Head,useForm } from '@inertiajs/inertia-vue3';
import { useToast } from 'vue-toastification';
import ConfigurationCreate from '@/Pages/Configuration/ConfigurationCreate.vue';
import ConfigurationView from '@/Pages/Configuration/ConfigurationView.vue';
import { ref,reactive } from 'vue'

  /** PROPS */
  const props = defineProps({
    errors: Object,
    configurations: Array
  });

  /** TOAST NOTIFICATION */
  const toast = useToast();


  /** CREATE MODAL TOGGLE */
  const isCreateModalShown = ref(false)
  
  const toggleCreateModal = () => {
    form.reset()
    isCreateModalShown.value = !isCreateModalShown.value;
  };

   /** VIEW MODAL TOGGLE */
  const isViewModalShown = ref(false)
  
  let view_data = reactive({
    image: null,
    name: null,
    details: null,
    fee:null,
    id:null,
    image_preview:null,
  })
  
  const toggleViewModal = (data) => {
    view_data.image = data.image,
    view_data.name = data.name,
    view_data.details = data.details,
    view_data.fee = data.fee,
    view_data.id = data.id,
    isViewModalShown.value = !isViewModalShown.value;
  };


  /** DELETE */
   let form = useForm()
  const deleteConfiguration = (id) => {
    console.log(id)
    form.delete(route("configuration.destroy",id)),{
      preserveState: true,
      onSuccess: (response) => {
        toast.success('Config deleted successfully!');
        // form.reset()
      },
      onError: (error) => {
        toast.error('Something went wrong!');
      },
    }
  }

</script>
<template lang="">
    <Head title="Configuration" />
    <BreezeAuthenticatedLayout>
        <ContentLayout>
            <h1 class="text-2xl">Configurations</h1>
            <div class="flex justify-end">
                <button @click="toggleCreateModal" class="text-base bg-green-600 rounded-lg p-2 mt-2 hover:bg-green-700  rounded-md text-white text-base tracking-wider uppercase font-medium hover:cursor-pointer md:mr-32 md:mb-2"> Create </button>
            </div>
            <div   class="flex  justify-center h-screen space-y-3" >
                <table class="table-auto w-5/6 border-4">
                    <thead>
                      <tr>
                        <!-- <th class="px-4 py-2 border">Image</th> -->
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Fee</th>
                        <th class="px-4 py-2 border">Details</th>
                        <th class="px-4 py-2 border">Actions</th>
                      </tr>
                    </thead>
                    <tbody v-if="configurations.length > 0" v-for="config in configurations" :key="config.id">
                      <tr>
                        <td class="border  px-4 py-2 font-medium">{{config.name}}</td>
                        <td class="border  px-4 py-2 font-medium">{{config.fee}}</td>
                        <td class="border  px-4 py-2 font-medium">{{config.details}}</td>
                        <td class="border  px-4 py-2 font-medium space-x-2 flex justify-center">
                          <button type="submit" class="px-3 py-2 hover:bg-yellow-700 bg-yellow-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click="toggleViewModal(config)">View
                          </button>
                          <button type="submit" class="px-3 py-2 hover:bg-red-700 bg-red-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click.prevent="deleteConfiguration(config.id)">Delete
                            </button>
                        </td>
                      </tr>
                  </tbody>
                  <tbody v-else >
                    <tr >
                      <td colspan="4" class="text-center font-base font-semibold">No Existing Data ...</td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <ConfigurationCreate v-model="isCreateModalShown" :errors="errors"/>
            <ConfigurationView v-model="isViewModalShown" :data="view_data" :errors="errors"/>
        </ContentLayout>
    </BreezeAuthenticatedLayout>
</template>