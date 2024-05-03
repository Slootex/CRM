
      <div class="mt-0">
            <input wire:model="file" type="file" name="file" id="file" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">

            <input wire:keydown.enter="sendMessage('{{session("username")}}')" wire:model="message" type="text" name="message" id="message" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
    </div>
    