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


        <div class="fs-eval-panel">

            {{-- PM evaluation panel --}}
            @if( (Auth::user()->hasrole('Admin') || Auth::user()->hasrole('Program Manager') ) && $canView1)
            <div class="fs-eval-panel-inner mb-4">
                <h6 class="fs-eval-title">PM Evaluation</h6>

                @if(session('rating-saved'))
                    <div class="fs-eval-alert fs-eval-alert-success">Saved successfully.</div>
                @endif

                <div class="mb-3">
                    <label class="fs-eval-label">Status</label>
                    <div class="fs-eval-radios" style="display: flex; flex-direction: column;">
                        <label class="fs-eval-radio-option {{ $pm_form_status === 'yes' ? 'active success' : '' }}" style="display: block;">
                            <input type="radio" wire:model="pm_form_status" value="yes" {{ !$canEdit1 ? 'disabled' : '' }}> Yes
                        </label>
                        <label class="fs-eval-radio-option {{ $pm_form_status === 'no' ? 'active danger' : '' }}" style="display: block;">
                            <input type="radio" wire:model="pm_form_status" value="no" {{ !$canEdit1 ? 'disabled' : '' }}> No
                        </label>
                        <label class="fs-eval-radio-option {{ $pm_form_status === 'maybe' ? 'active warning' : '' }}" style="display: block;">
                            <input type="radio" wire:model="pm_form_status" value="maybe" {{ !$canEdit1 ? 'disabled' : '' }}> Maybe
                        </label>
                    </div>
                    @error('pm_form_status')
                        <div class="fs-eval-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="fs-eval-label" for="pmNotes">Notes</label>
                    <textarea id="pmNotes" wire:model="pm_form_notes" class="fs-eval-textarea" rows="5" placeholder="Add your notes..." {{ !$canEdit1 ? 'disabled' : '' }}></textarea>
                </div>

                <button
                    type="button"
                    wire:click="savePmRating"
                    wire:loading.attr="disabled"
                    wire:target="savePmRating"
                    class="fs-eval-btn"
                    {{ !$canEdit1 ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="savePmRating">Save Evaluation</span>
                    <span wire:loading wire:target="savePmRating">Saving...</span>
                </button>
            </div>
            @endif

            {{-- Fixed evaluation panel --}}
            @if($assign_id && $form_type == 1)
            <div class="fs-eval-panel-inner">
                <h6 class="fs-eval-title">{{ $assigned_to }} Evaluation</h6>

                @if(session('rating-saved'))
                    <div class="fs-eval-alert fs-eval-alert-success">Saved successfully.</div>
                @endif

                <div class="mb-3">
                    <label class="fs-eval-label">Status</label>
                    <div class="fs-eval-radios" style="display: flex; flex-direction: column;">
                        <label class="fs-eval-radio-option {{ $form_status === 'yes' ? 'active success' : '' }}" style="display: block;">
                            <input type="radio" wire:model="form_status" value="yes" {{ !$canEdit2 ? 'disabled' : '' }}> Yes
                        </label>
                        <label class="fs-eval-radio-option {{ $form_status === 'no' ? 'active danger' : '' }}" style="display: block;">
                            <input type="radio" wire:model="form_status" value="no" {{ !$canEdit2 ? 'disabled' : '' }}> No
                        </label>
                        <label class="fs-eval-radio-option {{ $form_status === 'maybe' ? 'active warning' : '' }}" style="display: block;">
                            <input type="radio" wire:model="form_status" value="maybe" {{ !$canEdit2 ? 'disabled' : '' }}> Maybe
                        </label>
                    </div>
                    @error('form_status')
                        <div class="fs-eval-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="fs-eval-label" for="jurorNotes">Notes</label>
                    <textarea id="jurorNotes" wire:model="form_notes" class="fs-eval-textarea" rows="5" placeholder="Add your notes..." {{ !$canEdit2 ? 'disabled' : '' }}></textarea>
                </div>

                <button
                    type="button"
                    wire:click="saveJRRating"
                    wire:loading.attr="disabled"
                    wire:target="saveJRRating"
                    class="fs-eval-btn"
                    {{ !$canEdit2 ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="saveJRRating">Save</span>
                    <span wire:loading wire:target="saveJRRating">Saving...</span>
                </button>
            </div>
            @endif

            {{-- Form type 2: 4 scored questions --}}
            @if($assign_id && ( $form_type == 2 || $form_type == 3 ))
            <div class="fs-eval-panel-inner">
                <h6 class="fs-eval-title">{{ $assigned_to }} Evaluation</h6>

                {{-- Question 1 (4 options) --}}
                <div class="mb-4">
                    <div class="fs-eval-header-row">
                        <label class="fs-eval-label">RELEVANCE AND CONNECTIVITY | الصلة والتواصل</label>
                        <button type="button" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')" class="fs-eval-toggle" title="Show/hide details">
                            <svg class="fs-eval-toggle-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <p class="fs-eval-question-text hidden">
                        Relevance of the project to the context where the artist or institution operates.<br>
                        Relevance of the project to the broader arts and culture scene, and to the literary scene in general.<br>
                        Connectivity of the project to audiences and surrounding communities, and the diversity and inclusivity of the groups served.<br>
                        Connectivity of the project to wider discussions/topics and/or to other fields (e.g. academia, social sciences, political sciences, humanities, other artistic disciplines).<br><br>
                        صلة المشروع بالسياق الذي يعمل ضمنه الفنان/ة أو المؤسسة.<br>
                        صلة المشروع بالمشهد العام للفنون والثقافة، وبالساحة الأدبية عامة.<br>
                        تواصل المشروع مع الجمهور والمجتمعات المحيطة، وتنوّع المجموعات المستهدفة وشموليتها.<br>
                        تواصل المشروع مع نقاشات/مواضيع أوسع و/أو مع مجالات أخرى (الأكاديميا، العلوم الاجتماعية، العلوم السياسية، العلوم الإنسانية، الحقول الفنية الأخرى).<br>
                    </p>
                    <div class="fs-eval-radios fs-eval-radios-row">
                        @foreach([1,2,3,4] as $val)
                        <label class="fs-eval-radio-option {{ (int)$form_rate1 === $val ? 'active selected' : '' }}">
                            <input type="radio" wire:model="form_rate1" value="{{ $val }}" {{ !$canEdit2 ? 'disabled' : '' }}> {{ $val }}
                        </label>
                        @endforeach
                    </div>
                    @error('form_rate1') <div class="fs-eval-error">{{ $message }}</div> @enderror
                </div>

                {{-- Question 2 (4 options) --}}
                <div class="mb-4">
                    <div class="fs-eval-header-row">
                        <label class="fs-eval-label">QUALITY AND INNOVATION | النوعية والإبتكار</label>
                        <button type="button" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')" class="fs-eval-toggle" title="Show/hide details">
                            <svg class="fs-eval-toggle-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <p class="fs-eval-question-text hidden">
                        Proposal as a whole (coherence, clarity, etc.).<br>
                        Contribution/standing of the project to the field of specialization.<br>
                        Elements of innovation/originality (at the level of tools, topic, artistic approach/treatment, etc.). Elements related to the language itself (at the level of contemporaneity, experimentation, innovation).<br>
                        Past experiences/projects.<br><br>
                        الطلب المقدم بشكل عام من حيث الترابط المنطقي والوضوح...<br>
                        المساهمة في مجال التخصص.<br>
                        عناصر الابتكار والأصالة (على مستوى الأدوات، الموضوع، المقاربة والمعالجة الفنية). عناصر متعلقة باللغة نفسها (على مستوى الحداثة، التجريب، الإبداع).<br>
                        الخبرات السابقة / المشاريع السابقة.<br>
                    </p>
                    <div class="fs-eval-radios fs-eval-radios-row">
                        @foreach([1,2,3,4] as $val)
                        <label class="fs-eval-radio-option {{ (int)$form_rate2 === $val ? 'active selected' : '' }}">
                            <input type="radio" wire:model="form_rate2" value="{{ $val }}" {{ !$canEdit2 ? 'disabled' : '' }}> {{ $val }}
                        </label>
                        @endforeach
                    </div>
                    @error('form_rate2') <div class="fs-eval-error">{{ $message }}</div> @enderror
                </div>

                {{-- Question 3 (2 options) --}}
                <div class="mb-4">
                    <div class="fs-eval-header-row">
                        <label class="fs-eval-label">ADMINISTRATIVE/TECHNICAL QUESTIONS | الأسئلة التقنية والإدارية </label>
                        <button type="button" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')" class="fs-eval-toggle" title="Show/hide details">
                            <svg class="fs-eval-toggle-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <p class="fs-eval-question-text hidden">
                        Budget (feasibility of the proposed project, balanced distribution of the requested amounts).<br>
                        Implementation plan (clear, realistic results).<br>
                        Outputs.<br><br>
                        الميزانية (قابلية تنفيذ المشروع المقترح، والتوزيع المتوازن للمبالغ المطلوبة).<br>
                        خطة التنفيذ (نتائج واضحة وواقعية).<br>
                        المخرجات المقترحة.<br>
                    </p>
                    <div class="fs-eval-radios fs-eval-radios-row">
                        @foreach([1,2] as $val)
                        <label class="fs-eval-radio-option {{ (int)$form_rate3 === $val ? 'active selected' : '' }}">
                            <input type="radio" wire:model="form_rate3" value="{{ $val }}" {{ !$canEdit2 ? 'disabled' : '' }}> {{ $val }}
                        </label>
                        @endforeach
                    </div>
                    @error('form_rate3') <div class="fs-eval-error">{{ $message }}</div> @enderror
                </div>

                {{-- Question 4 (2 options) --}}
                @if($form_type == 3)
                <div class="mb-4">
                    <div class="fs-eval-header-row">
                        <label class="fs-eval-label">ADDITIONAL POINTS | علامة إضافية</label>
                        <button type="button" onclick="this.parentElement.nextElementSibling.classList.toggle('hidden')" class="fs-eval-toggle" title="Show/hide details">
                            <svg class="fs-eval-toggle-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <p class="fs-eval-question-text hidden">
                        Does the project require particular attention because it comes from countries that lack cultural structures, and where support for culture and the arts is a vital necessity?<br>
                        Does the project bring added value at the level of the topic?<br><br>
                        هل من المهم دعم المشروع بسبب السياق العام في البلد حيث يتم تنفيذ المشروع و/أو بسبب افتقار الساحة الثقافية المحلية لحركة ثقافية وآليات دعم وتطوير؟<br>
                        هل للمشروع القدرة على إثارة نقاش نقدي حول مواضيع أو ثيمات محددة تستحق الدعم والتطوير حالياً؟<br>
                    </p>
                    <div class="fs-eval-radios fs-eval-radios-row">
                        @foreach([0,1] as $val)
                        <label class="fs-eval-radio-option {{ (int)$form_rate4 === $val ? 'active selected' : '' }}">
                            <input type="radio" wire:model="form_rate4" value="{{ $val }}" {{ !$canEdit2 ? 'disabled' : '' }}> {{ $val }}
                        </label>
                        @endforeach
                    </div>
                    @error('form_rate4') <div class="fs-eval-error">{{ $message }}</div> @enderror
                </div>
                @endif

                {{-- Notes --}}
                <div class="mb-3">
                    <label class="fs-eval-label" for="rateNotes2">Notes</label>
                    <textarea id="rateNotes2" wire:model="form_notes" class="fs-eval-textarea" rows="4" placeholder="Add your notes..." {{ !$canEdit2 ? 'disabled' : '' }}></textarea>
                </div>
                

                <button
                    type="button"
                    wire:click="saveJRRating"
                    wire:loading.attr="disabled"
                    wire:target="saveJRRating"
                    class="fs-eval-btn"
                    {{ !$canEdit2 ? 'disabled' : '' }}
                >
                    <span wire:loading.remove wire:target="saveJRRating">Save</span>
                    <span wire:loading wire:target="saveJRRating">Saving...</span>
                </button>
            </div>
            @endif

        </div>
        

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
                width: 35%;
                flex-shrink: 0;
                position: sticky;
                top: 16px;
                align-self: flex-start;
                max-height: calc(100vh - 32px);
                overflow-y: auto;
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

            .fs-eval-radio-option input[type="radio"]:disabled {
                cursor: not-allowed;
            }

            label:has(input[type="radio"]:disabled) {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .fs-eval-radio-option.active.success { border-color: #22c55e; background: #f0fdf4; color: #15803d; }
            .fs-eval-radio-option.active.danger  { border-color: #ef4444; background: #fef2f2; color: #b91c1c; }
            .fs-eval-radio-option.active.warning { border-color: #f59e0b; background: #fffbeb; color: #b45309; }
            .fs-eval-radio-option.active.selected { border-color: #6366f1; background: #eef2ff; color: #4338ca; }

            .fs-eval-radios-row {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .fs-eval-radios-row .fs-eval-radio-option {
                flex: 1;
                justify-content: center;
                min-width: 48px;
            }

            .fs-eval-header-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
            }

            .fs-eval-toggle {
                flex-shrink: 0;
                width: 24px;
                height: 24px;
                padding: 0;
                border: none;
                background: transparent;
                cursor: pointer;
                color: #9ca3af;
                transition: color .15s;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .fs-eval-toggle:hover {
                color: #6b7280;
            }

            .fs-eval-toggle-icon {
                width: 100%;
                height: 100%;
            }

            .fs-eval-question-text {
                font-size: 13px;
                color: #6b7280;
                margin: 8px 0 8px;
                max-height: 500px;
                overflow: hidden;
                transition: max-height .3s ease, opacity .25s ease;
                opacity: 1;
            }

            .fs-eval-question-text.hidden {
                max-height: 0;
                opacity: 0;
                margin: 0;
            }

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

            .fs-eval-textarea:disabled {
                background-color: #f3f4f6;
                cursor: not-allowed;
                opacity: 0.6;
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
            .fs-eval-btn:disabled { 
                opacity: .6; 
                cursor: not-allowed;
                background: #9ca3af;
            }

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
