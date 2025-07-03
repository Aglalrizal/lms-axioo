@props(['id' => 'password', 'name' => 'password'])

<div class="input-group mb-3">
    <input class="form-control" type="password" id={{ $id }} name={{ $name }} value="" required>
    <span class="input-group-text">
        <i class="bi bi-eye" id="togglePassword" style="cursor: pointer" data-target="#{{ $id }}"
            data-toggle="password"></i>
    </span>
</div>
