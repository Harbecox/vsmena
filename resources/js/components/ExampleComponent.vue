<template>
    <div>
        <x-form.modal>
            <x-slot:title>
                Открыть смену
            </x-slot:title>
            <x-slot:button>
                <button class="btn btn-success">Открыть смену</button>
            </x-slot:button>
            <x-slot:body>
                <div class="d-flex justify-content-center w-100 align-items-center h-100">
                    <form class="w-100" data-class="AddEventRequest" method="POST" action="{{ route('events.open') }}">

                    </form>
                </div>
            </x-slot:body>
        </x-form.modal>

    </div>

</template>

<script>
export default {
    name: 'ExampleComponent',
}
</script>
