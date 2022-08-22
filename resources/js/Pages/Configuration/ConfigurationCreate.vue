<script setup>
/** IMPORTS */
import Modal from '@/Components/Modal/Modal.vue'
import FormInput from '@/Components/Input/FormInput.vue'
import FormTextArea from '@/Components/Input/FormTextArea.vue'
import { useConfigurationForm } from '@/Use/useConfigurationForm.js'
import { useForm } from '@inertiajs/inertia-vue3'
import { useToast } from 'vue-toastification';
import { onMounted } from 'vue'

/** TOAST NOTIFICATION */
const toast = useToast();

/** COMPOSABLES */
const { form } = useConfigurationForm()

/** UPLOADE IMAGE */
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

    reader.readAsDataURL(form.image_preview)
}
/** RESET IMAGE */
 const resetUploadedImage = () => {
     form.image_preview = null;
     form.image = null;
  };

/** PROPS */
const props = defineProps({
    modelValue:{
        type:Boolean,
        default:null
    },
    errors:{
        type:Object
    }
})

/** EMIT */
const emit = defineEmits( ['update:modelValue'])

/** SAVE CONFIG */
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
 onMounted(() =>{
    
 })
</script>
<template>
    <Modal v-if="modelValue" @close="$emit('update:modelValue',false)">
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
                        <input id="avatar" type="file" @change="imageSelected" class="hidden" accept="image/*"/>
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
        </template>
    </Modal>
</template>
