<select>
    @foreach ($sub_kriteria as $sub)
        <option value="{{ $sub->nilai_sub_kriteria }}">{{ $sub->nilai_sub_kriteria }}</option>
    @endforeach
</select>
