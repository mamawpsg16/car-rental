<script setup>
import { onMounted, ref } from 'vue' 
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import ContentLayout from '@/Layouts/ContentLayout.vue';
import { Head,useForm } from '@inertiajs/inertia-vue3';
import FormInput from '@/Components/Input/FormInput.vue'
import FormInputSelect from '@/Components/Input/FormInputSelect.vue'
import FormTextArea from '@/Components/Input/FormTextArea.vue'

  /** STATE MANAGEMENT */
  // const storeAuth = useStoreAuth()

  /** PROPS */
  const props = defineProps({
    user: Object,
    errors: Object,
  });

  /** FORM */
  let form = useForm({
    name: null,
    address:null,
    gender: null,
    image: null,
    email: null,
    date_of_birth: null,
    contact_number: null,
    image_preview:null,
    current_password: null,
  });


  /**  UPDATE IMAGE */
  const imageSelected = (event) => {
    console.log(event)
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
    console.log('reset')
    form.image_preview = null;
    form.image = null;
  };
  
  /** UPDATE FORM*/
  const updateSettings = () => {
    form.post(`/settings/update`, {
        preserveState: true,
        preserveScroll: true,
        onError: () => {
        // toast.error('So0mething went wrong!');
        },
        onSuccess: () => {
        // toast.success('Account updated successfully!');
        form.image = null;
        form.image_preview = null;
        // toggleConfirmModal();
        // form.current_password = null;
        },
    });
  };

  
  /** LIFECYCLE HOOKS */
  onMounted(() => {
    form.name = props.user.name;
    form.address = props.user.address;
    form.gender = props.user.gender;
    form.image = props.user.image;
    form.date_of_birth = props.user.date_of_birth;
    form.contact_number = props.user.contact_number;
    form.email = props.user.email;
    form.image_preview = null;
  
  });


</script>
<template lang="">
    <Head title="Settings" />
    <BreezeAuthenticatedLayout>
        <form  @submit.prevent="updateSettings"></form>
        <ContentLayout>
            <div class="py-12 max-w-7xl mx-auto slm:px-6 g:px-8 border-b border-gray-200 pb-5">
                  <div class="max-w-7xl mx-auto px-6 lg:px-8">
                      <div class="bg-white overflow-hidden  sm:rounded-lg">
                          <p class="text-xl font-medium">Account Settings</p>
                          <p class="text-sm">Please make sure all of your informations are correct.</p>
                      </div>
                  </div>
              </div>
              <div class="flex justify-center mt-2">
                  <div class="w-36 rounded h-24  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                      <svg v-if="!props.user.image && !form.image_preview" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="gray" stroke-width="1">
                          <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                      </svg>
                      <img v-else-if="form.image_preview" :src="form.image_preview" class="object-fit  h-full" alt="" />
                      <img v-else :src="`images/profile/${props.user.image}`" class="object-fit  h-full" alt="" />
                  </div>
              </div>
              <div>
                  <div class="flex justify-center">
                      <input id="avatar" type="file" @change="imageSelected" class="hidden" accept="image/*" />
                      <label for="avatar" class="px-3 py-2 hover:bg-blue-700 bg-blue-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mr-2 mt-2 ">Upload Image</label>
                      <button type="submit" class="px-3 py-2 bg-red-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click="resetUploadedImage" :disabled="!form.image_preview">Reset Image</button>
                  </div>
              </div>
              <div class="container mx-auto flex flex-col px-4 justify-center mt-10 spa-12 md:space-y-0 md:flex-row">
                  <div class="space-y-3 sm:w-full md:w-2/5">
                      <form action="">
                          <FormInput id="email" v-model="form.email" name="email" type="email" placeholder="Enter your email" label="Email" :error="errors.email">
                          </FormInput>

                          <FormInput id="name" v-model="form.name" type="text" placeholder="Enter your name" label="Name" :error="errors.name">
                          </FormInput>

                          <FormInput id="contact_number" v-model="form.contact_number" type="text" placeholder="Enter your contact number" label="Contact Number" :error="errors.contact_number">
                          </FormInput>
                  
                          <FormInput id="birthday" v-model="form.date_of_birth" name="birthday" type="date" placeholder="Enter your birthday" label="Birthday" :error="errors.date_of_birth">
                          </FormInput>

                          <FormTextArea id="address" v-model="form.address" placeholder="Enter your address" label="Address" :error="errors.address"></FormTextArea>

                          <FormInputSelect id="gender" label="Gender" v-model="form.gender" :error="errors.gender">
                              <option>Please select your gender</option>
                              <option value="Male" class="font-medium">Male</option>
                              <option value="Female" class="font-medium">Female</option>
                          </FormInputSelect>
                      </form>
                      <div class="flex justify-end">
                          <button type="submit" class="px-3 py-2  hover:bg-blue-700 bg-blue-600 rounded-md text-white text-base tracking-wider uppercase font-medium hover:cursor-pointer mt-2" @click.prevent="updateSettings">Update</button>
                      </div>
                  </div>
                  <!-- <div class="flex flex-col space-y-3 ml-4 sm:w-full lg:w-2/5">
                          
                  </div> -->
            </div>
        </ContentLayout>
    </BreezeAuthenticatedLayout>
</template>
