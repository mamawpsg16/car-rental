<script setup>
const props = defineProps({
    modelValue:{
        type:String
    },
    label:{
        type:String
    },
    id:{
        type:String   
    },
    error:{
        type:Object,
        default:null
    }
    
})
  /** EMITS */
  const emit = defineEmits(['update:modelValue']);

  const updateValue = (event) => {
    emit('update:modelValue', event.target.value);
  };

  /** CLOSE MODAL */
// const closeModal = ()=>{
//     emit('update:modelValue',false)
// }

</script>

<template lang="">
    <div class="mb-5">
      <label class="text-base font-medium text-gray-700">{{ props.label }}</label>
        <select
            @input="updateValue"
            v-model="modelValue"
            autocomplete="id"
            class="peer ring-0 outline-none border-2 p-3 placeholder-transparent rounded-lg w-full border-gray-400 dark:border-gray-600 text-gray-900 bg-transparent focus:border-blue-500"
            :class="{ 'border-red-400' : error}"
        >
            <slot/>
        </select>
         <span v-if="error" class="text-sm text-red-500">{{ error }}</span>
        
    </div>
</template>