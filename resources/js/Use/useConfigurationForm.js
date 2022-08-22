import { useForm } from '@inertiajs/inertia-vue3'

// by convention, composable function names start with "use"
export function useConfigurationForm() {
  // state encapsulated and managed by the composable
  const form = useForm({
    image: null,
    name: null,
    details: null,
    fee:null,
    id:null,
    image_preview:null,
 });

 
  // expose managed state as return value
  return { form }
}