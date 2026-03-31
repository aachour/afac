<div>
    <div class="fs-submission-wrapper">
        <div class="fs-submission-card">
            <div class="fs-submission-header">
                <div>
                    <h2 class="fs-title">Submission Details</h2>
                </div>
            </div>

            <div class="fs-fields">
                @forelse($fieldData as $field)
                    @if($field['value']!=null)
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
                    @endif
                @empty
                    <div class="fs-empty-state">
                        No submission data found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
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
        }
    </style>

</div>
