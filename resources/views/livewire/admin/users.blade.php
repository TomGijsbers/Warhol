<div>
    <x-tmk.section x-data="{ open: false }" class="p-0 mb-4 flex flex-col gap-2">
        <div class="p-4 flex justify-between items-start gap-4">
            <div class="relative w-64">
                <x-jet-input id="newUserName" type="text" placeholder="New User Name" x-data=""
                             wire:model.defer="newUserName" x-init="$el.focus()" class="w-full shadow-md placeholder-gray-300" />
                <x-phosphor-arrows-clockwise wire:loading wire:target="createUser"
                                             class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin" />
            </div>
            <div class="relative w-64">
                <select id="newUserAdmin"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md placeholder-gray-300 block w-full"
                        wire:model.defer="newUserAdmin">
                    <option selected value="">Admin Status</option>
                    <option value="1">
                        Admin
                    </option>
                    <option value="0">
                        Not Admin
                    </option>
                </select>
                <x-phosphor-arrows-clockwise wire:loading wire:target="createUser"
                                             class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin" />
            </div>
            <div class="relative w-64">
                <x-jet-input id="newUserEmail" type="text" placeholder="New User Email" x-data=""
                             wire:model.defer="newUserEmail" x-init="$el.focus()"
                             class="w-full shadow-md placeholder-gray-300" />
                <x-phosphor-arrows-clockwise wire:loading wire:target="createUser"
                                             class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin" />
            </div>
            <div class="relative w-64">
                <x-jet-input id="newUserPassword" type="text" placeholder="New User Password" x-data=""
                             wire:keydown.enter="createUser()" wire:keydown.tab="createUser()"
                             wire:keydown.escape="resetNewUser()" wire:model.defer="newUserPassword" x-init="$el.focus()"
                             class="w-full shadow-md placeholder-gray-300" />
                <x-phosphor-arrows-clockwise wire:loading wire:target="createUser"
                                             class="w-5 h-5 text-gray-200 absolute top-3 right-2 animate-spin" />
            </div>
            <x-heroicon-o-information-circle @click="open = !open" class="w-5 text-gray-400 cursor-help outline-0" />
        </div>
        <x-jet-input-error for="newUserName" class="m-4 -mt-4 w-full" />
        <x-jet-input-error for="newUserEmail" class="m-4 -mt-4 w-full" />
        <x-jet-input-error for="newUserPassword" class="m-4 -mt-4 w-full" />
        <x-jet-input-error for="newUserAdmin" class="m-4 -mt-4 w-full" />
        <div x-show="open" style="display: none" class="text-sky-900 bg-sky-50 border-t p-4">
            <x-tmk.list type="ul" class="list-outside mx-4 text-sm">
                <li>
                    <b>A new user</b> can be added by typing in the password field and pressing <b>enter</b> or
                    <b>tab</b>. Press <b>escape</b> to undo.
                </li>
                <li>
                    <b>Edit a user</b> by clicking the
                    <x-phosphor-pencil-line-duotone class="w-5 inline-block" />
                    icon or by clicking on the user name. Press <b>enter</b> to save, <b>escape</b> to undo.
                </li>
                <li>
                    Clicking the
                    <x-heroicon-o-information-circle class="w-5 inline-block" />
                    icon will toggle this message on and off.
                </li>
            </x-tmk.list>
        </div>
    </x-tmk.section>

    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <colgroup>
                <col class="w-14">
                <col class="w-20">
                <col class="w-16">
                <col class="w-max">
            </colgroup>
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2 cursor-pointer">
                <th wire:click="resort('id')">
                    <span data-tippy-content="Order by id">#</span>
                    <x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                            {{ $orderAsc ?: 'rotate-180' }}
                            {{ $orderBy === 'id' ? 'inline-block' : 'hidden' }}" />
                </th>
                <th wire:click="resort('name')" class="text-left">
                    <span data-tippy-content="Order by user">Name</span>
                    <x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                            {{ $orderAsc ?: 'rotate-180' }}
                            {{ $orderBy === 'name' ? 'inline-block' : 'hidden' }} " />
                </th>
                <th wire:click="resort('email')" class="text-left">
                    <span data-tippy-content="Order by email">Email</span>
                    <x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                            {{ $orderAsc ?: 'rotate-180' }}
                            {{ $orderBy === 'name' ? 'inline-block' : 'hidden' }} " />
                </th>
                <th wire:click="resort('admin')" class="text-left">
                    <span data-tippy-content="Order by admin">Admin</span>
                    <x-heroicon-s-chevron-up
                        class="w-5 text-slate-400
                            {{ $orderAsc ?: 'rotate-180' }}
                            {{ $orderBy === 'name' ? 'inline-block' : 'hidden' }} " />
                </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr wire:key="user_{{ $user->id }}" class="border-t border-gray-300 [&>td]:p-2">
                    <td>{{ $user->id }}</td>
                    @if ($editUser['id'] !== $user->id)
                        <td class="text-left cursor-pointer" style="width: 30%;">{{ $user->name }}
                        </td>
                        <td class="text-left cursor-pointer">{{ $user->email }}
                        </td>
                        <td class="text-left cursor-pointer">{{ $user->admin ? '✅' : '❌' }}
                        </td>
                    @else
                        <td>
                            <div class="flex flex-col text-left">
                                <x-jet-input id="edit_name_{{ $user->id }}" type="text"
                                             wire:model.defer="editUser.name"
                                             wire:keydown.enter="updateUser({{ $user->id }})"
                                             wire:keydown.tab="updateUser({{ $user->id }})"
                                             wire:keydown.escape="resetEditUser()" class="w-48" />
                                <x-jet-input-error for="editUser.name" class="mt-2" />
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col text-left">
                                <x-jet-input id="edit_email_{{ $user->id }}" type="email"
                                             wire:model.defer="editUser.email"
                                             wire:keydown.enter="updateUser({{ $user->id }})"
                                             wire:keydown.tab="updateUser({{ $user->id }})"
                                             wire:keydown.escape="resetEditUser()" class="w-48" />
                                <x-jet-input-error for="editUser.email" class="mt-2" />
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col text-left">
                                <select id="edit_admin_{{ $user->id }}"
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-md placeholder-gray-300 block w-full"
                                        wire:model.defer="editUser.admin"
                                        wire:keydown.enter="updateUser({{ $user->id }})"
                                        wire:keydown.tab="updateUser({{ $user->id }})"
                                        wire:keydown.escape="resetEditUser()">
                                    <option selected value="">Admin Status</option>
                                    <option value="1">
                                        Admin
                                    </option>
                                    <option value="0">
                                        Not Admin
                                    </option>
                                </select>
                                <x-jet-input-error for="editUser.name" class="mt-2" />
                            </div>
                        </td>
                    @endif
                    <td x-data="">
                        @if ($editUser['id'] !== $user->id)
                            <div
                                class="flex gap-1 justify-center [&>*]:cursor-pointer [&>*]:outline-0 [&>*]:transition">
                                <x-phosphor-pencil-line-duotone wire:click="editExistingUser({{ $user->id }})"
                                                                class="w-5 text-gray-300 hover:text-green-600" />
                                <x-phosphor-trash-duotone
                                    @click="$dispatch('swal:confirm', {
                                title: 'Delete {{ $user->name }}?',
                                icon: '{{ $user->paintings_count > 0 ? 'warning' : '' }}',
                                background: '{{ $user->paintings_count > 0 ? 'error' : '' }}',
                                cancelButtonText: 'NO!',
                                confirmButtonText: 'YES DELETE THIS USER',
                                next: {
                                    event: 'delete-user',
                                    params: {
                                        id: {{ $user->id }}
                                    }
                                }
                });"
                                    class="w-5 text-gray-300 hover:text-red-600" />
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-tmk.section>
</div>
