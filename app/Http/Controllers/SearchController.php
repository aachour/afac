<?php

namespace App\Http\Controllers;

use App\Models\Entries;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /** Entries shown per page in each section (2 rows of 4). */
    private const PER_PAGE = 8;

    /**
     * Searchable categories: key => [type_id, EN label, AR label, searchable columns].
     */
    private const CATEGORIES = [
        'events' => [1, 'Events', 'الفعاليات', ['event_title', 'event_title_arabic', 'event_text', 'event_text_arabic']],
        'programs' => [2, 'Programs', 'البرامج', ['program_title', 'program_title_arabic', 'program_text', 'program_text_arabic']],
        'projects' => [3, 'Supported Projects', 'المشاريع المدعومة', ['project_title', 'project_title_arabic', 'project_text', 'project_text_arabic']],
        'grantees' => [4, 'Grantees', 'المستفيدون', ['grantee_name', 'grantee_name_arabic', 'grantee_text', 'grantee_text_arabic']],
        'news' => [7, 'News', 'الأخبار', ['news_title', 'news_title_arabic', 'news_text', 'news_text_arabic']],
        'jurors' => [5, 'Jurors', 'لجان التحكيم', ['jury_name', 'jury_name_arabic', 'jury_text', 'jury_text_arabic']],
    ];

    /**
     * AJAX: load one page of one section using offset/limit (POST /get/search).
     */
    public function getSearchSection(Request $request)
    {
        $key = (string) $request->input('section');
        $term = trim((string) $request->input('term'));
        $page = max(1, (int) $request->input('page', 1));

        if (!isset(self::CATEGORIES[$key]) || $term === '') {
            return response('', 422);
        }

        [$typeId, $label, $labelAr, $columns] = self::CATEGORIES[$key];

        $limit = self::PER_PAGE;
        $offset = ($page - 1) * $limit;

        $query = $this->searchQuery($typeId, $columns, $term);
        $entries = $query->orderByDesc('id')->skip($offset)->take($limit)->get();

        return $this->renderCards($entries, $typeId);
    }

    private function searchQuery(int $typeId, array $columns, string $term)
    {
        $like = '%' . addcslashes($term, '%_\\') . '%';

        return Entries::where('type_id', $typeId)
            ->where('published', 1)
            ->whereNull('deleted_at')
            ->where(function ($q) use ($columns, $like) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', $like);
                }
            });
    }

    public function search(Request $request, string $term = '')
    {
        $term = trim(urldecode($term));
        $isEn = app()->getLocale() == 'en';

        $sections = [];
        $totalResults = 0;

        foreach (self::CATEGORIES as $key => [$typeId, $label, $labelAr, $columns]) {
            if ($term === '') {
                continue;
            }

            $query = $this->searchQuery($typeId, $columns, $term);
            $total = (clone $query)->count();
            if ($total == 0) {
                continue;
            }

            // First page only; further pages are loaded by AJAX (offset/limit).
            $entries = $query->orderByDesc('id')->take(self::PER_PAGE)->get();
            $totalResults += $total;

            $sections[$key] = [
                'title' => $isEn ? $label : $labelAr,
                'total' => $total,
                'pages' => (int) ceil($total / self::PER_PAGE),
                'cards' => $this->renderCards($entries, $typeId),
            ];
        }

        return view('frontend.search', [
            'term' => $term,
            'sections' => $sections,
            'totalResults' => $totalResults,
            'headerBgCode' => '#FFF',
            'footerBgCode' => '#FFF',
            'menuBgCode' => '#D2F8FE',
            'footer' => getFooter(),
        ]);
    }

    /**
     * Render entry cards with the same component used on the /projects page.
     */
    private function renderCards($entries, int $typeId): string
    {
        $html = '';

        foreach ($entries as $entry) {
            $image_path = !empty($entry->image)
                ? asset('storage/' . $entry->image)
                : asset('frontend/images/default-image.png');

            $details = getEntryDetails($typeId, $entry);

            $html .= '<div class="entry">';
            $html .= view('frontend.entry-hover-animation', [
                'collection_type_id' => $typeId,
                'entry_href' => $details['entry_href'],
                'entry_target' => $details['entry_target'],
                'image_path' => $image_path,
                'entry_title' => $details['entry_title'],
                'entry_position' => $details['entry_position'] ?? null,
                'entry_text' => $details['entry_text'],
                'title_position' => 'bottom:15px;',
                'with_label' => '1',
                'labels_position' => 'top:15px;',
                'entry_type_name' => $entry->type?->name,
                'labels' => getEntryLabels($entry),
                'button_text' => 'More',
                'button_text_arabic' => 'المزيد',
                'button_bg_color' => '#F1F1F1',
                'featured' => '0',
                'event_category_name' => $entry->eventCategory?->name,
                'event_start_date' => $entry->event_start_date,
                'event_end_date' => $entry->event_end_date,
                'program_start_date' => $entry->program_start_date,
                'program_end_date' => $entry->program_end_date,
                'project_categories' => $entry->projectCategoriesName(json_decode($entry->project_categories_id ?? '[]', true) ?? []),
                'project_countries' => $entry->projectCountries(json_decode($entry->project_countries_id ?? '[]', true) ?? []),
                'grantee_categories' => $entry->granteeCategories(json_decode($entry->grantee_categories_id ?? '[]', true) ?? []),
                'grantee_country' => $entry->granteeCountry?->name,
                'jury_country_id' => $entry->jury_country_id,
                'resource_category_name' => $entry->resourceCategory?->name,
                'resource_date' => $entry->resource_date,
                'news_date' => $entry->news_date,
            ])->render();
            $html .= '</div>';
        }

        return $html;
    }
}
