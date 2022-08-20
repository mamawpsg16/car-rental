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
    cols:{
        type:Number,
        default:0
    },
    rows:{
        type:Number,
        default:0
    },
    error:{
        type:Object,
        default:null
    }
    
})

  /** EMITS */
//   const emit = defineEmits(['update:modelValue']);

//   const updateValue = (event) => {
//     emit('update:modelValue', event.target.value);
//   };

  /** CLOSE MODAL */
// const closeModal = ()=>{
//     emit('update:modelValue',false)
// }

</script>

<template lang="">
    <div>
      <label class="text-base font-medium text-gray-700">{{ props.label }}</label>
       <!-- <select
            class="peer ring-0 outline-none border-2 p-2 placeholder-transparent rounded-lg w-full border-gray-400 dark:border-gray-600 text-gray-900 bg-transparent focus:border-blue-500"
        > -->
        <textarea
            @input="$emit('update:modelValue',modelValue)"
            v-model="modelValue"
            autocomplete="id"
            rows="rows"
            cols="cols"
             :class="{ 'border-red-400': error }"
            class="peer ring-0 outline-none border-2 p-3 placeholder-transparent rounded-lg w-full border-gray-400 dark:border-gray-600 text-gray-900 bg-transparent focus:border-blue-500"
        >
        </textarea>
        <p v-if="error !== null" class="text-sm text-red-500">{{ error }}</p>
        
    </div>
</template>