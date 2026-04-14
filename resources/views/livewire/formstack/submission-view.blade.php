<div>
    <div class="fs-page-layout {{ $assign_id ? 'fs-has-panel' : '' }}">
    <div class="fs-submission-wrapper">
        <div class="fs-submission-card">
            <div class="fs-submission-header">
                <div>
                    <h2 class="fs-title">Submission Details</h2>
                </div>
            </div>

            <div class="fs-fields">
                @forelse($fieldData as $field)
                    <div class="fs-field-row">
                        <div class="fs-field-label">
                            {{ $field['label'] }}
                        </div>

                        <div class="fs-field-value">
                            @php
                                $value = $field['value'];
                            @endphp

                            @if(is_array($value))
                                <ul class="fs-value-list">
                                    @foreach($value as $item)
                                        <li>{{ $item ?: '-' }}</li>
                                    @endforeach
                                </ul>
                            @elseif(!is_null($value) && $value !== '')
                                {!! nl2br(e($value)) !!}
                            @else
                                <span class="fs-empty">No value submitted</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="fs-empty-state">
                        No submission data found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Fixed evaluation panel --}}
    @if($assign_id && $form_type == 1)
    <div class="fs-eval-panel">
        <div class="fs-eval-panel-inner">
            <h6 class="fs-eval-title">Evaluation</h6>

            @if(session('rating-saved'))
                <div class="fs-eval-alert fs-eval-alert-success">Saved successfully.</div>
            @endif

            <div class="mb-3">
                <label class="fs-eval-label">Status</label>
                <div class="fs-eval-radios">
                    <label class="fs-eval-radio-option {{ $form_status === 'yes' ? 'active success' : '' }}">
                        <input type="radio" wire:model="form_status" value="yes"> Yes
                    </label>
                    <label class="fs-eval-radio-option {{ $form_status === 'no' ? 'active danger' : '' }}">
                        <input type="radio" wire:model="form_status" value="no"> No
                    </label>
                    <label class="fs-eval-radio-option {{ $form_status === 'maybe' ? 'active warning' : '' }}">
                        <input type="radio" wire:model="form_status" value="maybe"> Maybe
                    </label>
                </div>
                @error('form_status')
                    <div class="fs-eval-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="fs-eval-label" for="jurorNotes">Notes</label>
                <textarea id="jurorNotes" wire:model="juror_notes" class="fs-eval-textarea" rows="5" placeholder="Add your notes..."></textarea>
            </div>

            <button
                type="button"
                wire:click="saveRating"
                wire:loading.attr="disabled"
                wire:target="saveRating"
                class="fs-eval-btn"
            >
                <span wire:loading.remove wire:target="saveRating">Save</span>
                <span wire:loading wire:target="saveRating">Saving...</span>
            </button>
        </div>
    </div>
    @endif

    <style>
        .fs-page-layout {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        .fs-page-layout .fs-submission-wrapper {
            flex: 1;
            min-width: 0;
        }

        /* Eval panel */
        .fs-eval-panel {
            width: 280px;
            flex-shrink: 0;
            position: sticky;
            top: 80px;
            align-self: flex-start;
        }

        .fs-eval-panel-inner {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            padding: 20px;
        }

        .fs-eval-title {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .fs-eval-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .fs-eval-radios {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .fs-eval-radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            transition: border-color .15s, background .15s;
        }

        .fs-eval-radio-option input[type="radio"] {
            margin: 0;
        }

        .fs-eval-radio-option.active.success { border-color: #22c55e; background: #f0fdf4; color: #15803d; }
        .fs-eval-radio-option.active.danger  { border-color: #ef4444; background: #fef2f2; color: #b91c1c; }
        .fs-eval-radio-option.active.warning { border-color: #f59e0b; background: #fffbeb; color: #b45309; }

        .fs-eval-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
        }

        .fs-eval-textarea {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #111827;
            resize: vertical;
            outline: none;
            transition: border-color .15s;
        }

        .fs-eval-textarea:focus {
            border-color: #6366f1;
        }

        .fs-eval-btn {
            width: 100%;
            padding: 10px;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .fs-eval-btn:hover:not(:disabled) { background: #4f46e5; }
        .fs-eval-btn:disabled { opacity: .6; cursor: not-allowed; }

        .fs-eval-alert { padding: 8px 12px; border-radius: 8px; font-size: 13px; margin-bottom: 14px; }
        .fs-eval-alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        .fs-submission-wrapper {
            max-width: 100%;
        }

        .fs-submission-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .fs-submission-header {
            padding: 22px 24px;
            border-bottom: 1px solid #eceff3;
            background: #f9fafb;
        }

        .fs-title {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
        }

        .fs-subtitle {
            margin: 6px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        .fs-fields {
            padding: 8px 0;
        }

        .fs-field-row {
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 20px;
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            align-items: start;
        }

        .fs-field-row:last-child {
            border-bottom: none;
        }

        .fs-field-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            padding-top: 8px;
        }

        .fs-field-value {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px 14px;
            min-height: 44px;
            font-size: 14px;
            line-height: 1.6;
            color: #111827;
            white-space: normal;
            word-break: break-word;
        }

        .fs-empty {
            color: #9ca3af;
            font-style: italic;
        }

        .fs-empty-state {
            padding: 24px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .fs-value-list {
            margin: 0;
            padding-left: 18px;
        }

        .fs-value-list li {
            margin-bottom: 4px;
        }

        @media (max-width: 768px) {
            .fs-field-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .fs-field-label {
                padding-top: 0;
            }

            .fs-page-layout {
                flex-direction: column;
            }

            .fs-eval-panel {
                width: 100%;
                position: static;
            }
        }
    </style>

    </div>{{-- /.fs-page-layout --}}

    @script
    <script>
        $wire.on('rating-saved', () => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Rating saved!',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                });
            }
        });
    </script>
    @endscript
</div>
