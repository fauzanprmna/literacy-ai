@extends(Auth::user()->role === 'admin' ? 'template.template-admin' : 'template.template-mahasiswa')

@section('title', 'Detail Template Jawaban')
@section('header', 'Detail Template Jawaban')

@push('head')
<style>

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 13px; font-weight: 600; color: var(--gray-600);
        text-decoration: none; padding: 8px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-sm);
        background: var(--white); transition: all .15s; margin-bottom: 20px;
    }
    .back-link:hover { background: var(--gray-100); color: var(--gray-800); }

    .detail-card {
        background: var(--white); border: 1px solid var(--gray-200);
        border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden;
    }

    .detail-hero {
        background: linear-gradient(135deg, var(--green-800) 0%, var(--green-700) 100%);
        padding: 22px 26px; display: flex; align-items: center; gap: 14px;
        position: relative; overflow: hidden;
    }
    .detail-hero::after {
        content: ''; position: absolute; bottom: -30px; right: -30px;
        width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,.05);
    }
    .dh-icon {
        width: 42px; height: 42px; border-radius: var(--radius-md);
        background: rgba(255,255,255,.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--g3); flex-shrink: 0; position: relative; z-index: 1;
    }
    .dh-title { font-size: 17px; font-weight: 700; color: #fff; position: relative; z-index: 1; margin-bottom: 3px; }
    .dh-sub { font-size: 12px; color: rgba(255,255,255,.55); position: relative; z-index: 1; }

    .detail-section {
        padding: 20px 24px; border-bottom: 1px solid var(--gray-100);
    }
    .detail-section:last-child { border-bottom: none; }
    .section-label {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .08em; color: var(--gray-400); margin-bottom: 14px;
    }

    /* Answer list */
    .answer-list { display: flex; flex-direction: column; gap: 8px; }
    .answer-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px;
        border: 1px solid var(--gray-200); border-radius: var(--radius-md);
        transition: border-color .12s, box-shadow .12s;
    }
    .answer-item:hover { border-color: var(--green-300); box-shadow: var(--shadow-sm); }
    .ans-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--green-700); color: #fff;
        font-size: 11px; font-weight: 800;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .ans-names { flex: 1; min-width: 0; }
    .ans-name-id { font-size: 13px; font-weight: 600; color: var(--gray-800); }
    .ans-name-en { font-size: 11px; color: var(--gray-400); margin-top: 1px; }
    .ans-bobot {
        background: var(--green-50); color: var(--green-700);
        border: 1px solid var(--green-100);
        border-radius: 20px; padding: 3px 10px;
        font-size: 12px; font-weight: 700; flex-shrink: 0;
    }

    /* Translations row */
    .trans-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .trans-item {
        border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: 12px 14px;
    }
    .trans-locale { font-size: 10px; font-weight: 700; color: var(--green-600); margin-bottom: 5px; }
    .trans-value  { font-size: 13px; color: var(--gray-800); font-weight: 500; }

    /* Actions */
    .action-row { display: flex; gap: 8px; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); text-decoration: none;
        background: #fef3c7; color: #92400e; border: 1px solid #fde68a; transition: all .15s;
    }
    .btn-edit:hover { background: #fde68a; }
    .btn-del {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 18px; font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm); border: none; cursor: pointer;
        background: #fee2e2; color: #991b1b; transition: all .15s;
    }
    .btn-del:hover { background: #fecaca; }

    @media (max-width: 576px) { .trans-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="detail-wrap">
    <a href="{{ route('answer-template.index') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <div class="detail-card">
        <!-- Hero -->
        <div class="detail-hero">
            <div class="dh-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
            <div>
                <p class="dh-title">{{ $template->name }}</p>
                <p class="dh-sub">{{ $template->defaultAnswers->count() }} pilihan jawaban</p>
            </div>
        </div>

        <!-- Translations -->
        @if ($template->translations && $template->translations->count() > 0)
            <div class="detail-section">
                <p class="section-label">Nama Template</p>
                <div class="trans-grid">
                    @foreach ($template->translations as $t)
                        <div class="trans-item">
                            <p class="trans-locale">{{ strtoupper($t->locale) === 'ID' ? '🇮🇩 Indonesia' : '🇬🇧 English' }}</p>
                            <p class="trans-value">{{ $t->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Answers -->
        <div class="detail-section">
            <p class="section-label">Pilihan Jawaban</p>
            <div class="answer-list">
                @forelse($template->defaultAnswers as $i => $ans)
                    <div class="answer-item">
                        <span class="ans-num">{{ $i + 1 }}</span>
                        <div class="ans-names">
                            <p class="ans-name-id">{{ $ans->name }}</p>
                            @php $enName = $ans->translations->where('locale','en')->first()->name ?? null; @endphp
                            @if ($enName)
                                <p class="ans-name-en">{{ $enName }}</p>
                            @endif
                        </div>
                        <span class="ans-bobot">Bobot {{ $ans->bobot }}</span>
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--gray-400);">Belum ada pilihan jawaban.</p>
                @endforelse
            </div>
        </div>

        <!-- Actions -->
        <div class="detail-section">
            <div class="action-row">
                <a href="{{ route('answer-template.edit', $template) }}" class="btn-edit">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('answer-template.destroy', $template) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus template ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection