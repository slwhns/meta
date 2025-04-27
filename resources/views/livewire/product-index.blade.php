<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="flex flex-col gap-6">
        <div class="rounded-xl border">
            <br>
            <flux:heading class="px-10 text-center" size="xl"> {{ $productID ? 'Edit Product' : 'Add Product' }}</flux:heading>
            <div class="px-10 py-8">
                <form wire:submit.prevent="save" class="space-y-4 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="name" label="Product name" placeholder="Enter product name" />
                        <flux:textarea wire:model="description" label="Description" placeholder="Enter product description" />
                        <flux:input wire:model="price" label="Price (RM)" placeholder="Enter price" />
                        <flux:button type="submit" variant="primary"> {{ $productID ? 'Update' : 'Add Product' }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>

    <div class="flex flex-col gap-6">
        <div class="text-center text-green-600 bold p-5">
            {{  session('message') }}
        </div>
        <div class="rounded-xl border">
            <div class="px-10 py-8">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price (RM)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $p)
                        <tr class="text-center">
                            <td> {{ $index+1 }}</td>
                            <td> {{  $p->name }}</td>
                            <td style="min-width: 400px"> {{  $p->description }}</td>
                            <td> {{  $p->price }}</td>
                            <td class="p-2">
                                <flux:button wire:click="edit({{ $p->id }})" icon="pencil" variant="primary"></flux:button>
                                <flux:button wire:click="$dispatch('confirmDelete', {{ $p->id }})" icon="trash" variant="danger"></flux:button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 <div class="text-center p-2">
                     {{ $products->links() }}
                 </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('productSaved', function({message}){
                Swal.fire('Success!', message, 'success') //success, error, warning, info, question
            })
            Livewire.on('confirmDelete', function(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', {id: id});
                    }
                })
            });
        });
    </script>
</div>