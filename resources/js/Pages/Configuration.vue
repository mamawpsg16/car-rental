<script setup>
/** IMPORTS */
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import ContentLayout from '@/Layouts/ContentLayout.vue';
import { Head,useForm } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal/Modal.vue'
import FormInput from '@/Components/Input/FormInput.vue'
import FormTextArea from '@/Components/Input/FormTextArea.vue'
import { useToast } from 'vue-toastification';
import { ref, onMounted } from 'vue'

 /** PROPS */
  const props = defineProps({
    errors: Object,
    configurations: Array
  });

  /** TOAST NOTIFICATION */
  const toast = useToast();


  /** FORM */
  let form = useForm({
    image: null,
    name: null,
    details: null,
    fee:null,
    image_preview:null,
  });

  /** CREATE MODAL TOGGLE */
  const isCreateModalShown = ref(false)
  const toggleCreateModal = () => {
    isCreateModalShown.value = !isCreateModalShown.value;
  };

  /** EDIT MODAL TOGGLE */
  const isEditModalShown = ref(false)
  const toggleEditModal = () => {
    // isViewModalShown.value = false;
    isEditModalShown.value = !isEditModalShown.value;
  };

  /** VIEW MODAL TOGGLE */
  const isViewModalShown = ref(false)
  let modal_data = ref(null)
  const toggleViewModal = (data) => {
    modal_data.value = data
    isViewModalShown.value = !isViewModalShown.value;
  };
  

  /**  UPDATE IMAGE */
  const imageSelected = (event) => {
    form.image = event.target.files[0];
    form.image_preview = event.target.files[0];

    if (!form.image) {
      return false;
    }

    if (!form.image.type.match('image.*')) {
      return false;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      form.image_preview = e.target.result;
    };

    reader.readAsDataURL(form.image_preview);
  };

  const resetUploadedImage = () => {
    form.image_preview = null;
    form.image = null;
  };
 const saveConfiguration = () =>{
    form.post(route('configuration.store'),{
      onSuccess: (response) => {
        toast.success('Config added successfully!');
        form.reset()
      },
      onError: (error) => {
        toast.error('Something went wrong!');
      },
    })
 }

  /** EDIT CONFIG */
 

  const deleteConfiguration = (id) => {
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


//  onMounted( ()=>{
//     toast('IM A TOAST MF')
//  })
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
            <Modal v-if="isViewModalShown" @close="toggleViewModal">
              <template #title>
                <div class="px-5 pt-5 pb-3 font-bold">
                  {{modal_data.name}}
                </div>
              </template>
              <template #body>
                <div class="px-5 pb-2">
                  <div class="flex justify-center mt-2">
                      <div class="w-36 rounded h-28  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                          <img :src="`images/car-images/${modal_data.image}`" class="object-fit  h-full" alt="" />
                      </div>
                  </div>
                  <div class="mt-5">
                    <p class="flex  justify-center">{{modal_data.name}}</p>
                    <p class="flex  justify-center">{{modal_data.details}}</p>
                  </div>
                </div>
              </template>
              <template #footer>
                <div class="flex justify-end px-5 py-4">
                  <button @click="toggleEditModal" class="text-base bg-blue-600 rounded-lg py-2 px-4 mt-2 hover:bg-blue-700  rounded-md text-white text-base tracking-wider uppercase font-medium hover:cursor-pointer"> Edit </button>
                </div>
              </template>
            </Modal>
            <!-- <Modal v-model="isEditModalShown">
              <template #title>
                    Title
              </template>
            </Modal> -->
            <Modal v-if="isCreateModalShown" @close="toggleCreateModal">
                <template v-slot:title>
                    <p class="font-bold text-xl">Add Configuration</p>
                </template>
                <template v-slot:body>
                    <form action="" class="mt-2">
                        <div class="flex justify-center mt-2">
                            <div class="w-36 rounded h-24  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                                <img v-if="form.image_preview" :src="form.image_preview" class="object-fit  h-full" alt="" />
                            </div>
                        </div>
                          <p v-if="errors.image" class="text-sm flex justify-center text-red-500 mt-2">{{ errors.image }}</p>
                        <div>
                            <div class="flex justify-center">
                                <input id="avatar" type="file" @change="imageSelected" class="hidden" accept="image/*" />
                                <label for="avatar" class="px-3 py-2 hover:bg-blue-700 bg-blue-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mr-2 mt-2 ">Upload Image</label>
                                <button type="submit" class="px-3 py-2 hover:bg-red-700 bg-red-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click="resetUploadedImage" :disabled="!form.image_preview">Reset Image</button>
                            </div>
                        </div>
                         <div class="container flex flex-col px-4 space-y-5 justify-center mt-10">

                            <FormInput id="name" v-model="form.name" name="name" type="text" placeholder="Enter name" label="Name" :error="errors.name"/>

                            <FormInput id="fee" v-model="form.fee" name="fee" type="number" placeholder="Enter fee" label="Fee" :error="errors.fee"/>

                             <FormTextArea id="details" v-model="form.details" placeholder="Enter details" label="Details" :error="errors.details"/>

                         </div>
                    </form>
                </template>
                <template v-slot:footer>
                      <button type="submit" class="px-3 py-2  bg-green-700 text-white rounded-md text-base tracking-wider uppercase font-medium  hover:cursor-pointer mt-2" size="sm" @click.prevent="saveConfiguration" :disabled="form.processing">Save</button>
                    <!-- <Button @click.prevent="toggleUpdatePasswordModal" text size="sm" color="gray">Close</Button> -->
                    <!-- <Button @click.prevent="updatePassword" text size="sm" color="success">Save Changes</Button> -->
                </template>
            </Modal>
        </ContentLayout>
    </BreezeAuthenticatedLayout>
</template>