@extends('applicants.app')

@section('title', 'Pilih Bidang & Atur Prioritas Jurusan')

@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            @if($hasChosen ?? false)
                <!-- Tampilan terkunci -->
                <div class="card border-0 shadow-sm text-center py-5">
                    <i class="bi bi-lock-fill text-primary" style="font-size: 4.5rem;"></i>
                    <h3 class="fw-bold text-primary mt-4">Pilihan Jurusan Terkunci</h3>
                    <p class="lead text-muted">Kamu sudah menyimpan pilihan dan tidak dapat mengubahnya lagi.</p>
                    <ol class="list-group list-group-numbered w-75 mx-auto mt-4">
                        @foreach($chosenMajors as $c)
                            <li class="list-group-item d-flex justify-content-between py-3">
                                <div>
                                    <div class="fw-bold">{{ $c->major->nama }}</div>
                                    <small class="text-muted">{{ $c->major->skillField->nama }}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">Prioritas {{ $c->priority }}</span>
                            </li>
                        @endforeach
                    </ol>
                    <div class="mt-4">
                        <a href="{{ route('applicants.dashboard') }}" class="btn btn-outline-primary px-5">Kembali</a>
                    </div>
                </div>

            @else
                <h4 class="fw-semibold mb-3">Pilih Bidang Keahlian</h4>
                <p class="text-muted mb-4">Pilih satu bidang keahlian, lalu atur urutan prioritas jurusan di dalamnya.</p>

                <form action="{{ route('applicants.choices.store') }}" method="POST" id="choice-form">
                    @csrf

                    <!-- PILIH BIDANG KEAHLIAN -->
                    <div class="row g-3 mb-5">
                        @foreach($skillFields as $field)
                            @if($field->majors->count() > 0)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input skill-field" type="radio" name="skill_field_id"
                                               id="field-{{ $field->id }}" value="{{ $field->id }}"
                                               {{ $selectedSkillFieldId == $field->id ? 'checked' : '' }}>
                                        <label class="form-check-label border rounded p-3 d-block hover-shadow cursor-pointer {{ $selectedSkillFieldId == $field->id ? 'border-primary bg-light' : '' }}"
                                               for="field-{{ $field->id }}">
                                            <strong class="d-block">{{ $field->nama }}</strong>
                                            <small class="text-muted">{{ $field->majors->count() }} jurusan tersedia</small>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- DAFTAR JURUSAN & PRIORITAS (akan muncul setelah pilih bidang) -->
                    <div id="major-priority-section" class="{{ $selectedSkillFieldId ? '' : 'd-none' }}">
                        <hr class="my-5">
                        <h5 class="fw-semibold mb-3">Atur Urutan Prioritas Jurusan</h5>
                        <p class="text-muted small mb-4">
                            Geser untuk mengubah urutan • <strong>Prioritas 1</strong> = pilihan utama
                        </p>

                        <ul id="chosen-list" class="list-group mb-4" style="min-height: 100px;">
                            @if($tempChoices->count() > 0)
                                @foreach($tempChoices as $choice)
                                    <li class="list-group-item d-flex align-items-center py-3" data-major-id="{{ $choice->major_id }}">
                                        <span class="badge bg-primary rounded-pill me-3" style="width:36px;height:36px;">{{ $loop->iteration }}</span>
                                        <div class="flex-grow-1">
                                            <strong>{{ $choice->major->nama }}</strong>
                                        </div>
                                        <input type="hidden" name="priorities[]" value="{{ $choice->major_id }}">
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <div id="empty-state" class="text-center text-muted py-5 {{ $tempChoices->count() > 0 ? 'd-none' : '' }}">
                            Pilih bidang keahlian terlebih dahulu.
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" id="submit-btn" class="btn btn-success px-5" disabled>
                            Simpan Pilihan Jurusan (Final)
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@if(!($hasChosen ?? false))
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const $list        = document.getElementById('chosen-list');
    const $section     = document.getElementById('major-priority-section');
    const $empty       = document.getElementById('empty-state');
    const $submitBtn   = document.getElementById('submit-btn');
    const majorsData   = @json($skillFields->pluck('majors', 'id')); // {fieldId: [{id,nama}, ...]}

    function updateButton() {
        $submitBtn.disabled = $list.children.length === 0;
    }

    function loadMajors(fieldId) {
        const majors = majorsData[fieldId] || [];
        $list.innerHTML = '';

        majors.forEach((major, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex align-items-center py-3';
            li.dataset.majorId = major.id;
            li.innerHTML = `
                <span class="badge bg-primary rounded-pill me-3" style="width:36px;height:36px;">${index + 1}</span>
                <div class="flex-grow-1"><strong>${major.nama}</strong></div>
                <input type="hidden" name="priorities[]" value="${major.id}">
            `;
            $list.appendChild(li);
        });

        $empty.classList.toggle('d-none', majors.length > 0);
        $section.classList.remove('d-none');
        updateButton();
        initSortable();
    }

    function initSortable() {
        if ($list.sortable) $list.sortable.destroy();
        new Sortable($list, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: () => {
                $list.querySelectorAll('li').forEach((li, i) => {
                    li.querySelector('.badge').textContent = i + 1;
                });
            }
        });
    }

    // Saat ganti bidang
    document.querySelectorAll('.skill-field').forEach(radio => {
        radio.addEventListener('change', function () {
            if ($list.children.length > 0) {
                Swal.fire({
                    title: 'Ganti Bidang Keahlian?',
                    text: 'Semua urutan prioritas sebelumnya akan direset.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ganti',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        loadMajors(this.value);
                    } else {
                        document.querySelector(`input[value="${document.querySelector('.skill-field:checked').value}"]`).checked = true;
                    }
                });
            } else {
                loadMajors(this.value);
            }
        });
    });

    // Kalau sudah ada pilihan sementara (reload halaman)
    @if($selectedSkillFieldId)
        loadMajors({{ $selectedSkillFieldId }});
    @endif

    // Submit dengan konfirmasi
    document.getElementById('choice-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if ($list.children.length === 0) {
            Swal.fire('Error', 'Pilih bidang keahlian dan atur prioritas terlebih dahulu.', 'error');
            return;
        }

        Swal.fire({
            title: 'Yakin dengan pilihanmu?',
            text: 'Setelah disimpan, kamu TIDAK BISA mengubah lagi!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan permanen!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endif
@endsection
