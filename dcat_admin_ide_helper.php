<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection edu_url
     * @property Grid\Column|Collection edu_xh
     * @property Grid\Column|Collection edu_mm
     * @property Grid\Column|Collection state
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection xh
     * @property Grid\Column|Collection mm
     * @property Grid\Column|Collection xm
     * @property Grid\Column|Collection xb
     * @property Grid\Column|Collection sr
     * @property Grid\Column|Collection mz
     * @property Grid\Column|Collection xl
     * @property Grid\Column|Collection xy
     * @property Grid\Column|Collection zy
     * @property Grid\Column|Collection bj
     * @property Grid\Column|Collection xz
     * @property Grid\Column|Collection nj
     * @property Grid\Column|Collection sf
     * @property Grid\Column|Collection xn
     * @property Grid\Column|Collection xq
     * @property Grid\Column|Collection kh
     * @property Grid\Column|Collection km
     * @property Grid\Column|Collection kx
     * @property Grid\Column|Collection cj
     * @property Grid\Column|Collection xf
     * @property Grid\Column|Collection jd
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection school_id
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection admin_id
     * @property Grid\Column|Collection command
     * @property Grid\Column|Collection parameters
     * @property Grid\Column|Collection expression
     * @property Grid\Column|Collection timezone
     * @property Grid\Column|Collection is_active
     * @property Grid\Column|Collection dont_overlap
     * @property Grid\Column|Collection run_in_maintenance
     * @property Grid\Column|Collection notification_email_address
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection edu_url(string $label = null)
     * @method Grid\Column|Collection edu_xh(string $label = null)
     * @method Grid\Column|Collection edu_mm(string $label = null)
     * @method Grid\Column|Collection state(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection xh(string $label = null)
     * @method Grid\Column|Collection mm(string $label = null)
     * @method Grid\Column|Collection xm(string $label = null)
     * @method Grid\Column|Collection xb(string $label = null)
     * @method Grid\Column|Collection sr(string $label = null)
     * @method Grid\Column|Collection mz(string $label = null)
     * @method Grid\Column|Collection xl(string $label = null)
     * @method Grid\Column|Collection xy(string $label = null)
     * @method Grid\Column|Collection zy(string $label = null)
     * @method Grid\Column|Collection bj(string $label = null)
     * @method Grid\Column|Collection xz(string $label = null)
     * @method Grid\Column|Collection nj(string $label = null)
     * @method Grid\Column|Collection sf(string $label = null)
     * @method Grid\Column|Collection xn(string $label = null)
     * @method Grid\Column|Collection xq(string $label = null)
     * @method Grid\Column|Collection kh(string $label = null)
     * @method Grid\Column|Collection km(string $label = null)
     * @method Grid\Column|Collection kx(string $label = null)
     * @method Grid\Column|Collection cj(string $label = null)
     * @method Grid\Column|Collection xf(string $label = null)
     * @method Grid\Column|Collection jd(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection school_id(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection admin_id(string $label = null)
     * @method Grid\Column|Collection command(string $label = null)
     * @method Grid\Column|Collection parameters(string $label = null)
     * @method Grid\Column|Collection expression(string $label = null)
     * @method Grid\Column|Collection timezone(string $label = null)
     * @method Grid\Column|Collection is_active(string $label = null)
     * @method Grid\Column|Collection dont_overlap(string $label = null)
     * @method Grid\Column|Collection run_in_maintenance(string $label = null)
     * @method Grid\Column|Collection notification_email_address(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection type
     * @property Show\Field|Collection edu_url
     * @property Show\Field|Collection edu_xh
     * @property Show\Field|Collection edu_mm
     * @property Show\Field|Collection state
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection xh
     * @property Show\Field|Collection mm
     * @property Show\Field|Collection xm
     * @property Show\Field|Collection xb
     * @property Show\Field|Collection sr
     * @property Show\Field|Collection mz
     * @property Show\Field|Collection xl
     * @property Show\Field|Collection xy
     * @property Show\Field|Collection zy
     * @property Show\Field|Collection bj
     * @property Show\Field|Collection xz
     * @property Show\Field|Collection nj
     * @property Show\Field|Collection sf
     * @property Show\Field|Collection xn
     * @property Show\Field|Collection xq
     * @property Show\Field|Collection kh
     * @property Show\Field|Collection km
     * @property Show\Field|Collection kx
     * @property Show\Field|Collection cj
     * @property Show\Field|Collection xf
     * @property Show\Field|Collection jd
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection school_id
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection admin_id
     * @property Show\Field|Collection command
     * @property Show\Field|Collection parameters
     * @property Show\Field|Collection expression
     * @property Show\Field|Collection timezone
     * @property Show\Field|Collection is_active
     * @property Show\Field|Collection dont_overlap
     * @property Show\Field|Collection run_in_maintenance
     * @property Show\Field|Collection notification_email_address
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection edu_url(string $label = null)
     * @method Show\Field|Collection edu_xh(string $label = null)
     * @method Show\Field|Collection edu_mm(string $label = null)
     * @method Show\Field|Collection state(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection xh(string $label = null)
     * @method Show\Field|Collection mm(string $label = null)
     * @method Show\Field|Collection xm(string $label = null)
     * @method Show\Field|Collection xb(string $label = null)
     * @method Show\Field|Collection sr(string $label = null)
     * @method Show\Field|Collection mz(string $label = null)
     * @method Show\Field|Collection xl(string $label = null)
     * @method Show\Field|Collection xy(string $label = null)
     * @method Show\Field|Collection zy(string $label = null)
     * @method Show\Field|Collection bj(string $label = null)
     * @method Show\Field|Collection xz(string $label = null)
     * @method Show\Field|Collection nj(string $label = null)
     * @method Show\Field|Collection sf(string $label = null)
     * @method Show\Field|Collection xn(string $label = null)
     * @method Show\Field|Collection xq(string $label = null)
     * @method Show\Field|Collection kh(string $label = null)
     * @method Show\Field|Collection km(string $label = null)
     * @method Show\Field|Collection kx(string $label = null)
     * @method Show\Field|Collection cj(string $label = null)
     * @method Show\Field|Collection xf(string $label = null)
     * @method Show\Field|Collection jd(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection school_id(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection admin_id(string $label = null)
     * @method Show\Field|Collection command(string $label = null)
     * @method Show\Field|Collection parameters(string $label = null)
     * @method Show\Field|Collection expression(string $label = null)
     * @method Show\Field|Collection timezone(string $label = null)
     * @method Show\Field|Collection is_active(string $label = null)
     * @method Show\Field|Collection dont_overlap(string $label = null)
     * @method Show\Field|Collection run_in_maintenance(string $label = null)
     * @method Show\Field|Collection notification_email_address(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
