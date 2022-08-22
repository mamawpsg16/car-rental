<script setup>
/** IMPORTS */
import Modal from '@/Components/Modal/Modal.vue'
import FormInput from '@/Components/Input/FormInput.vue'
import FormTextArea from '@/Components/Input/FormTextArea.vue'
import { useToast } from 'vue-toastification';
// import { useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3';

/** TOAST NOTIFICATION */
const toast = useToast

/** PROPS */
const props = defineProps({
    modelValue:{
        type:Boolean,
        default:false
    },
    data:{
        type:[Object,Array],
        default:null
    },
    errors:{
        type:Object,
        defalt:null
    }
})

/** EMIT */
const emit = defineEmits( ['update:modelValue'])

/** REFS */
const edit_config = ref(false)

// const form = useForm({
//     image:props.data.image,
//     name:props.data.name,
//     data:props.data.data,
//     fee:props.data.fee,
//     image_preview:null,
//     id:props.data.id
//     }
// )



/** EDIT MODAL TOGGLE */
const isEditModalShown = ref(false)

const toggleEditModal = () => {
    edit_config.value = true;
};


/** UPLOADE IMAGE */
const imageSelected = (event) => {
    console.log(props.data.image)
    props.data.image = event.target.files[0];
    props.data.image_preview = event.target.files[0];

    if (!props.data.image) {
      return false;
    }

    if (!props.data.image.type.match('image.*')) {
      return false;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
      props.data.image_preview = e.target.result;
    };

    reader.readAsDataURL(props.data.image_preview)
}

/** EDIT MODAL TOGGLE */
  const cancelEditModal = () => {
    edit_config.value = false;
  };

/** RESET IMAGE */
 const resetUploadedImage = () => {
     props.data.image_preview = null;
     props.data.image = null;
  };

/** UPDATE CONFIGURATION */
const updateConfiguration = () => {
    Inertia.patch(route('configuration.update',props.data.id),{
        data:props.data,
        onSuccess: ()=>{
            console.log('SUCCESS')
        },
        onError: ()=>{

        }
      })
      Inertia.patch(route('configuration.update', props.data.id), 
      {data: props.data}, 
      {onSuccess: () => { 
        console.log('Success')
       }, 
      onError: () => {

       }
      })
}
/** LIFECYCLE HOOKS */
onMounted(() =>{
    // form.image = props.data.image,
    // form.name = props.data.name,
    // form.data = props.data.data,
    // form.fee = props.data.fee,
    // form.id = props.data.id
})
 

</script>
<template>
        <section v-if="edit_config === false">
            <Modal v-if="modelValue" @close="$emit('update:modelValue',false)">
                <template #title>
                    <div class="px-5 pt-5 pb-3 font-bold">
                        {{data.name}}
                    </div>
                    </template>
                    <template #body>
                    <div class="px-5 pb-2">
                        <div class="flex justify-center mt-2">
                            <div class="w-36 rounded h-28  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                                <img :src="`images/car-images/${data.image}`" class="object-fit  h-full" alt="" />
                            </div>
                        </div>
                        <div class="mt-5">
                        <p class="flex  justify-center">{{data.name}}</p>
                        <p class="flex  justify-center">{{data.data}}</p>
                        </div>
                    </div>
                    </template>
                    <template #footer>
                    <div class="flex justify-end px-5 py-4">
                        <button @click="toggleEditModal" class="text-base bg-blue-600 rounded-lg py-2 px-4 mt-2 hover:bg-blue-700  rounded-md text-white text-base tracking-wider uppercase font-medium hover:cursor-pointer"> Edit </button>
                    </div>
                </template>
            </Modal>
        </section>
        <section v-else>
        <Modal>
            <template v-slot:title>
                <p class="font-bold text-xl">Update Configuration</p>
            </template>
            <template v-slot:body>
                <form action="" class="mt-2">
                    <div class="flex justify-center mt-2">
                        <div class="w-36 rounded h-24  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                            <img v-if="data.image_preview" :src="data.image_preview" class="object-fit  h-full" alt="" />
                            <img v-else :src="`images/car-images/${data.image}`" class="object-fit  h-full" alt="" />
                        </div>
                    </div>
                        <p v-if="errors.image" class="text-sm flex justify-center text-red-500 mt-2">{{ errors.image }}</p>
                    <div>
                        <div class="flex justify-center">
                            <input id="avatar" type="file" @change="imageSelected" class="hidden" accept="image/*" />
                            <label for="avatar" class="px-3 py-2 hover:bg-blue-700 bg-blue-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mr-2 mt-2 ">Upload Image</label>
                            <button type="submit" class="px-3 py-2 hover:bg-red-700 bg-red-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click="resetUploadedImage" :disabled="!data.image_preview">Reset Image</button>
                        </div>
                    </div>
                        <div class="container flex flex-col px-4 space-y-5 justify-center mt-10">

                        <FormInput id="name" v-model="data.name" name="name" type="text" placeholder="Enter name" label="Name" :error="errors.name"/>

                        <FormInput id="fee" v-model="data.fee" name="fee" type="number" placeholder="Enter fee" label="Fee" :error="errors.fee"/>

                        <FormTextArea id="data" v-model="data.details" placeholder="Enter data" label="Details" :error="errors.details"/>

                        </div>
                </form>
            </template>
            <template v-slot:footer>
                    <button type="submit" class="mr-2 px-3 py-2 border-2 border-black  text-black rounded-md text-base tracking-wider uppercase font-medium  hover:cursor-pointer mt-2" size="sm" @click.prevent="cancelEditModal">Cancel</button>
                    <button type="submit" class="px-3 py-2  bg-blue-700 text-white rounded-md text-base tracking-wider uppercase font-medium  hover:cursor-pointer mt-2" size="sm" @click.prevent="updateConfiguration" :disabled="data.processing">Update</button>
            </template>
        </Modal>
        </section>
        
</template>
