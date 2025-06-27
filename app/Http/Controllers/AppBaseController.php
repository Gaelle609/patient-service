<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use InvalidArgumentException;
use App\Traits\ApiResponserTrait;
use App\Traits\ConsumesExternalService;
use App\Traits\HasPermissionsTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Optimus\Architect\Architect;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

/**
 * @OA\Info(
 *     title="Task Manager API",
 *     version="1.0",
 *     description="API pour la gestion des tâches",
 *     @OA\Contact(
 *          email="steve.wiltek@thebrains-group.com",
 *          name="Steve Wiltek"
 *     ),
 *     @OA\License(
 *          name="SEHT Inc Sarl",
 *          url="https://seht.app"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="SEHT API's Endpoint"
 * )
 *
 * @OA\Tag(
 *     name="SEHT",
 *     description="API Endpoints of Projects"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class AppBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponserTrait, ConsumesExternalService, HasPermissionsTrait;


    // /**
    //  * Parse data using architect
    //  * @param  mixed $data
    //  * @param  array  $options
    //  * @param  string $key
    //  * @return mixed
    //  */
    // protected function parseData($data, array $options, $key = null)
    // {
    //     $architect = new Architect();
    //     $datas =  $architect->parseData($data, $options['modes'], $key);

    //     $urlPath = explode('/', url()->current());
    //     $table = last($urlPath);

    //     return $datas;

    //     // To use maybe later
    //     if (auth()->check()) {
    //         $user = request()->user();
    //         $datas['user_permissions'] = $user->getPermissions()->filter(function ($item) use ($table) {
    //             return strpos($item->slug, $table) !== false;
    //         })->map(function ($permission) {
    //             return collect($permission)->only(['id', 'name', 'slug', 'object', 'description', 'action'])->all();
    //         })->values();


    //         $agent = agent();
    //         $datas['agent_permissions'] = $agent ? $agent->getPermissions()->filter(function ($item) use ($table) {
    //             return strpos($item->slug, $table) !== false;
    //         })->map(function ($permission) {
    //             return collect($permission)->only(['id', 'name', 'slug', 'object', 'description', 'action'])->all();
    //         })->values() : [];
    //     } else {
    //         $datas['user_permissions'] = [];
    //         $datas['agent_permissions'] = [];
    //     }
    // }


    // /**
    //  * Parse selected fields strings into resource
    //  * @param  array  $select
    //  * @return array The parsed resources
    //  */
    // protected function parseSelect($select)
    // {
    //     if ($select === null) {
    //         return null;
    //     }

    //     if (is_array($select)) {
    //         $parsedSelect = $select;
    //     } elseif (is_string($select)) {
    //         $parsedSelect = explode(',', $select);
    //     } else {
    //         throw new InvalidArgumentException("Select must be an array or a list of fields separed with comma(',')");
    //     }

    //     return array_map('trim', $parsedSelect);
    // }


    // /**
    //  * Parse groupBy fields strings into resource
    //  * @param  array  $group_by
    //  * @return array The parsed resources
    //  */
    // protected function parseGroupBy($group_by)
    // {
    //     if ($group_by === null) {
    //         return null;
    //     }

    //     if (is_array($group_by)) {
    //         $parsedGroupBy = $group_by;
    //     } elseif (is_string($group_by)) {
    //         $parsedGroupBy = explode(',', $group_by);
    //     } else {
    //         throw new InvalidArgumentException("Select must be an array or a list of fields separed with comma(',')");
    //     }

    //     return array_map('trim', $parsedGroupBy);
    // }


    // /**
    //  * Page load
    //  * @param array $load
    //  * @return array
    //  */
    // protected function parseLoad(array $load)
    // {
    //     return array_map(function ($load) {

    //         if (!isset($load['relationship'])) {
    //             throw new InvalidArgumentException("Load doesn't have relationship key");
    //         }

    //         if (!isset($load['direction'])) {
    //             $load['direction'] = 'asc';
    //         } else {
    //             $load['direction'] = (strtolower($load['direction']) == 'asc') ? 'ASC' : 'DESC';
    //         }
    //         if (!isset($load['limit'])) {
    //             $load['limit'] = 5;
    //         }
    //         if (!isset($load['key'])) {
    //             $load['key'] = 'id';
    //         }

    //         if (isset($load['filter_groups'])) {
    //             $load['filter_groups'] = $this->parseFilterGroups($load['filter_groups']);
    //         }

    //         return $load;
    //     }, $load);
    // }

    // /**
    //  * Page load
    //  * @param array $load
    //  * @return array
    //  */
    // protected function parseWhereHas(array $wherehas)
    // {
    //     foreach ($wherehas as $key => $has) {
    //         if (!array_key_exists('relationship', $has)) {
    //             throw new InvalidArgumentException("WhereHas doesn't have relationship key");
    //         }

    //         if (array_key_exists('key', $has) && !array_key_exists('value', $has)) {
    //             throw new InvalidArgumentException("Value filter is required");
    //         }

    //         if (!isset($has['not'])) {
    //             $wherehas[$key]['not'] = false;
    //         } else {
    //             $wherehas[$key]['not'] = $wherehas[$key]['not'] == 'true' ? true : false;
    //         }
    //         if (!isset($has['operator'])) {
    //             $wherehas[$key]['operator'] = 'eq';
    //         }

    //         if (isset($has['load'])) {
    //             if (!isset($has['load']['direction'])) {
    //                 $wherehas[$key]['load']['direction'] = 'desc';
    //             } else {
    //                 $wherehas[$key]['load']['direction'] = (strtolower($wherehas[$key]['load']['direction']) == 'asc') ? 'ASC' : 'DESC';
    //             }
    //             if (!isset($has['load']['limit'])) {
    //                 $wherehas[$key]['load']['limit'] = 5;
    //             }
    //             if (!isset($has['load']['key'])) {
    //                 $wherehas[$key]['load']['key'] = 'id';
    //             }
    //         }

    //         if (isset($has['filter_groups'])) {
    //             $wherehas[$key]['filter_groups'] = $this->parseFilterGroups($has['filter_groups']);
    //         }
    //     }
    //     return $wherehas;
    // }


    // /**
    //  * Parse GET parameters into resource options
    //  * @return array
    //  */
    // protected function parseResourceOptions($request = null)
    // {
    //     if ($request === null) {
    //         $request = request();
    //     }

    //     $this->defaults = array_merge([
    //         'includes' => [],
    //         'sort' => [],
    //         'limit' => null,
    //         'page' => null,
    //         'mode' => 'embed',
    //         'filter_groups' => [],
    //         'start' => null,
    //         'load' => [],
    //         'wherehas' => [],
    //         'select' => null,
    //         'group_by' => null,
    //     ], $this->defaults);

    //     $includes = $this->parseIncludes($request->get('includes', $this->defaults['includes']));
    //     $load = $this->parseLoad($request->get('load', $this->defaults['load']));
    //     $wherehas = $this->parseWherehas($request->get('wherehas', $this->defaults['wherehas']));
    //     $sort = $this->parseSort($request->get('sort', $this->defaults['sort']));
    //     $limit = $request->get('limit', $this->defaults['limit']);
    //     $page = $request->get('page', $this->defaults['page']);
    //     $filter_groups = $this->parseFilterGroups($request->get('filter_groups', $this->defaults['filter_groups']));
    //     $start = $request->get('start', $this->defaults['start']);
    //     $select = $this->parseSelect($request->get('select', $this->defaults['select']));
    //     $group_by = $this->parseGroupBy($request->get('group_by', $this->defaults['group_by']));

    //     if ($page !== null && $limit === null) {
    //         throw new InvalidArgumentException('Cannot use page option without limit option');
    //     }

    //     return [
    //         'includes' => $includes['includes'],
    //         'modes' => $includes['modes'],
    //         'sort' => $sort,
    //         'limit' => $limit,
    //         'page' => $page,
    //         'filter_groups' => $filter_groups,
    //         'start' => $start,
    //         'select' => $select,
    //         'group_by' => $group_by,
    //         'load' => $load,
    //         'wherehas' => $wherehas,
    //     ];
    // }
}
