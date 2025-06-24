<details class="border rounded-lg mb-4" id="address-{{ $index }}">
    <summary class="px-4 py-2 bg-gray-100 flex justify-between items-center">
        <span>
            Morada {{ $index + 1 }} – {{ $addr['address'] ?? 'Sem tipo' }}
        </span>
        @if($index !== 0)
        <button type="button" onclick="removeAddress({{ $index }})" class="text-red-500 hover:text-red-700 text-xs">
            Remover
        </button>
        @endif
    </summary>

    <div class="p-4 bg-white grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="inline-flex items-center">
                <input type="radio" name="primaryIndex" id="primary-{{ $index }}" value="{{ $index }}"
                    {{ $primaryIndex == $index ? 'checked' : '' }} onclick="setPrimary({{ $index }})"
                    class="form-radio text-pink-600" />
                <span class="ml-2 text-sm">Morada Principal</span>
            </label>
        </div>

        <!-- Tipo -->
        <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">Tipo de Morada</label>
            <select name="addresses[{{ $index }}][address_type_id]" class="form-input">
                <option value="" disabled selected>Selecione o tipo</option>
                @foreach($addressTypes as $type)
                    <option value="{{ $type->id }}" {{ ($addr['address_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            @error("addresses.$index.address_type_id")
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nome -->
        <div>
            <label class="block text-gray-700 mb-1 text-sm font-medium">Nome</label>
            <input type="text" name="addresses[{{ $index }}][name]" value="{{ $addr['name'] ?? '' }}" class="form-input" />
            @error("addresses.$index.name")
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Restante campos -->
        <x-form.input name="addresses[{{ $index }}][address]" label="Morada" :value="$addr['address'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][line1]" label="Morada 2" :value="$addr['line1'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][line3]" label="Complemento" :value="$addr['line3'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][code]" label="Código Postal" :value="$addr['code'] ?? ''" maxlength="8" />
        <x-form.input name="addresses[{{ $index }}][localidade]" label="Localidade" :value="$addr['localidade'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][city]" label="Concelho" :value="$addr['city'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][state]" label="Distrito" :value="$addr['state'] ?? ''" />
        <x-form.input name="addresses[{{ $index }}][country]" label="País" :value="$addr['country'] ?? ''" />
    </div>
</details>
