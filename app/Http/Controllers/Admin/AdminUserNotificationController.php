<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\AdminUserNotificationRepositoryInterface;
use App\Http\Requests\Admin\AdminUserNotificationRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\AdminUserServiceInterface;
use App\Repositories\AdminUserRepositoryInterface;
use App\Services\AdminUserNotificationServiceInterface;

class AdminUserNotificationController extends Controller {

    /** @var \App\Repositories\AdminUserNotificationRepositoryInterface */
    protected $adminUserNotificationRepository;
    protected $adminUserNotificationService;
    protected $adminUserService;
    protected $adminUserRepository;


    public function __construct(
        AdminUserNotificationRepositoryInterface $adminUserNotificationRepository,
        AdminUserServiceInterface                $adminUserService,
        AdminUserRepositoryInterface             $adminUserRepository,
        AdminUserNotificationServiceInterface    $adminUserNotificationService
    ) {
        $this->adminUserNotificationRepository = $adminUserNotificationRepository;
        $this->adminUserService                = $adminUserService;
        $this->adminUserRepository             = $adminUserRepository;
        $this->adminUserNotificationService    = $adminUserNotificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index( PaginationRequest $request ) {
        $paginate[ 'offset' ] = $request->offset();
        $paginate[ 'limit' ] = $request->limit();
        $paginate[ 'order' ] = $request->order();
        $paginate[ 'direction' ] = $request->direction();
        $paginate[ 'baseUrl' ] = action( 'Admin\AdminUserNotificationController@index' );

        $count = $this->adminUserNotificationRepository->count();
        $models = $this->adminUserNotificationRepository->get(
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );

        return view(
            'pages.admin.admin-user-notifications.index',
            [
                'models'   => $models,
                'count'    => $count,
                'paginate' => $paginate,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create() {
        return view(
            'pages.admin.admin-user-notifications.edit',
            [
                'isNew'                 => true,
                'adminUserNotification' => $this->adminUserNotificationRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store( AdminUserNotificationRequest $request ) {
        $input = $request->only(
            [
                'category_type',
                'type',
                'data',
                'content',
                'locale',
                'sent_at'
            ]
        );

        $input[ 'sent_at' ]    = ( $input[ 'sent_at' ] != "" ) ? $input[ 'sent_at' ] : null;
        $input[ 'read' ] = $request->get( 'read', 0 );

        $model = $this->adminUserNotificationRepository->create( $input );

        if( empty( $model ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        return redirect()
            ->action( 'Admin\AdminUserNotificationController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.create_success' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function show( $id ) {
        $model = $this->adminUserNotificationRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.admin-user-notifications.edit',
            [
                'isNew'                 => false,
                'adminUserNotification' => $model,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     *
     * @return \Response
     */
    public function update( $id, AdminUserNotificationRequest $request ) {
        /** @var \App\Models\AdminUserNotification $model */
        $model = $this->adminUserNotificationRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $input = $request->only(
            [
                'category_type',
                'type',
                'data',
                'content',
                'locale',
                'sent_at'
            ]
        );

        $input[ 'sent_at' ]    = ( $input[ 'sent_at' ] != "" ) ? $input[ 'sent_at' ] : null;
        $input[ 'read' ] = $request->get( 'read', 0 );

        $this->adminUserNotificationRepository->update( $model, $input );

        return redirect()
            ->action( 'Admin\AdminUserNotificationController@show', [$id] )
            ->with( 'message-success', trans( 'admin.messages.general.update_success' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function destroy( $id ) {
        /** @var \App\Models\AdminUserNotification $model */
        $model = $this->adminUserNotificationRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $this->adminUserNotificationRepository->delete( $model );

        return redirect()
            ->action( 'Admin\AdminUserNotificationController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.delete_success' ) );
    }

    public function view($id)
    {
        $adminUser = $this->adminUserService->getUser();
        $adminUserNotification = $this->adminUserNotificationRepository->find( $id );
        if( empty( $adminUserNotification ) ) {
            \App::abort( 404 );
        }

        $input[ 'read' ] = 1;

        $this->adminUserNotificationRepository->update( $adminUserNotification, $input );

        $adminUser = $this->adminUserRepository->find($adminUser['id']);
        if( empty( $adminUser ) ) {
            \App::abort( 404 );
        }
        $input['last_notification_id'] = $id;

        $this->adminUserRepository->update( $adminUser, $input );
        return redirect()
            ->action( 'Admin\AdminUserNotificationController@index' );
    }

    public function loadNotification($offset)
    {
        $user = $this->adminUserService->getUser();
        $notifications = $this->adminUserNotificationService->getNotifications($user, $offset, 10);
        return $notifications;
    }

}
