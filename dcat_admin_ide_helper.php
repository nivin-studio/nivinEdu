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
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection admin_id
     * @property Grid\Column|Collection school_id
     * @property Grid\Column|Collection api_no
     * @property Grid\Column|Collection api_key
     * @property Grid\Column|Collection state
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection edu_url
     * @property Grid\Column|Collection edu_xh
     * @property Grid\Column|Collection edu_mm
     * @property Grid\Column|Collection application_id
     * @property Grid\Column|Collection student_no
     * @property Grid\Column|Collection annual
     * @property Grid\Column|Collection term
     * @property Grid\Column|Collection course_no
     * @property Grid\Column|Collection course_name
     * @property Grid\Column|Collection course_type
     * @property Grid\Column|Collection score
     * @property Grid\Column|Collection credit
     * @property Grid\Column|Collection gpa
     * @property Grid\Column|Collection request_url
     * @property Grid\Column|Collection request_type
     * @property Grid\Column|Collection request_body
     * @property Grid\Column|Collection response_body
     * @property Grid\Column|Collection period
     * @property Grid\Column|Collection week
     * @property Grid\Column|Collection section
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection week_period
     * @property Grid\Column|Collection teacher
     * @property Grid\Column|Collection location
     * @property Grid\Column|Collection student_password
     * @property Grid\Column|Collection student_name
     * @property Grid\Column|Collection identity_no
     * @property Grid\Column|Collection birth_date
     * @property Grid\Column|Collection gender
     * @property Grid\Column|Collection nation
     * @property Grid\Column|Collection education
     * @property Grid\Column|Collection college
     * @property Grid\Column|Collection major
     * @property Grid\Column|Collection class
     * @property Grid\Column|Collection grade
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection admin_id(string $label = null)
     * @method Grid\Column|Collection school_id(string $label = null)
     * @method Grid\Column|Collection api_no(string $label = null)
     * @method Grid\Column|Collection api_key(string $label = null)
     * @method Grid\Column|Collection state(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection edu_url(string $label = null)
     * @method Grid\Column|Collection edu_xh(string $label = null)
     * @method Grid\Column|Collection edu_mm(string $label = null)
     * @method Grid\Column|Collection application_id(string $label = null)
     * @method Grid\Column|Collection student_no(string $label = null)
     * @method Grid\Column|Collection annual(string $label = null)
     * @method Grid\Column|Collection term(string $label = null)
     * @method Grid\Column|Collection course_no(string $label = null)
     * @method Grid\Column|Collection course_name(string $label = null)
     * @method Grid\Column|Collection course_type(string $label = null)
     * @method Grid\Column|Collection score(string $label = null)
     * @method Grid\Column|Collection credit(string $label = null)
     * @method Grid\Column|Collection gpa(string $label = null)
     * @method Grid\Column|Collection request_url(string $label = null)
     * @method Grid\Column|Collection request_type(string $label = null)
     * @method Grid\Column|Collection request_body(string $label = null)
     * @method Grid\Column|Collection response_body(string $label = null)
     * @method Grid\Column|Collection period(string $label = null)
     * @method Grid\Column|Collection week(string $label = null)
     * @method Grid\Column|Collection section(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection week_period(string $label = null)
     * @method Grid\Column|Collection teacher(string $label = null)
     * @method Grid\Column|Collection location(string $label = null)
     * @method Grid\Column|Collection student_password(string $label = null)
     * @method Grid\Column|Collection student_name(string $label = null)
     * @method Grid\Column|Collection identity_no(string $label = null)
     * @method Grid\Column|Collection birth_date(string $label = null)
     * @method Grid\Column|Collection gender(string $label = null)
     * @method Grid\Column|Collection nation(string $label = null)
     * @method Grid\Column|Collection education(string $label = null)
     * @method Grid\Column|Collection college(string $label = null)
     * @method Grid\Column|Collection major(string $label = null)
     * @method Grid\Column|Collection class(string $label = null)
     * @method Grid\Column|Collection grade(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection email
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection admin_id
     * @property Show\Field|Collection school_id
     * @property Show\Field|Collection api_no
     * @property Show\Field|Collection api_key
     * @property Show\Field|Collection state
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection token
     * @property Show\Field|Collection edu_url
     * @property Show\Field|Collection edu_xh
     * @property Show\Field|Collection edu_mm
     * @property Show\Field|Collection application_id
     * @property Show\Field|Collection student_no
     * @property Show\Field|Collection annual
     * @property Show\Field|Collection term
     * @property Show\Field|Collection course_no
     * @property Show\Field|Collection course_name
     * @property Show\Field|Collection course_type
     * @property Show\Field|Collection score
     * @property Show\Field|Collection credit
     * @property Show\Field|Collection gpa
     * @property Show\Field|Collection request_url
     * @property Show\Field|Collection request_type
     * @property Show\Field|Collection request_body
     * @property Show\Field|Collection response_body
     * @property Show\Field|Collection period
     * @property Show\Field|Collection week
     * @property Show\Field|Collection section
     * @property Show\Field|Collection time
     * @property Show\Field|Collection week_period
     * @property Show\Field|Collection teacher
     * @property Show\Field|Collection location
     * @property Show\Field|Collection student_password
     * @property Show\Field|Collection student_name
     * @property Show\Field|Collection identity_no
     * @property Show\Field|Collection birth_date
     * @property Show\Field|Collection gender
     * @property Show\Field|Collection nation
     * @property Show\Field|Collection education
     * @property Show\Field|Collection college
     * @property Show\Field|Collection major
     * @property Show\Field|Collection class
     * @property Show\Field|Collection grade
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection admin_id(string $label = null)
     * @method Show\Field|Collection school_id(string $label = null)
     * @method Show\Field|Collection api_no(string $label = null)
     * @method Show\Field|Collection api_key(string $label = null)
     * @method Show\Field|Collection state(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection edu_url(string $label = null)
     * @method Show\Field|Collection edu_xh(string $label = null)
     * @method Show\Field|Collection edu_mm(string $label = null)
     * @method Show\Field|Collection application_id(string $label = null)
     * @method Show\Field|Collection student_no(string $label = null)
     * @method Show\Field|Collection annual(string $label = null)
     * @method Show\Field|Collection term(string $label = null)
     * @method Show\Field|Collection course_no(string $label = null)
     * @method Show\Field|Collection course_name(string $label = null)
     * @method Show\Field|Collection course_type(string $label = null)
     * @method Show\Field|Collection score(string $label = null)
     * @method Show\Field|Collection credit(string $label = null)
     * @method Show\Field|Collection gpa(string $label = null)
     * @method Show\Field|Collection request_url(string $label = null)
     * @method Show\Field|Collection request_type(string $label = null)
     * @method Show\Field|Collection request_body(string $label = null)
     * @method Show\Field|Collection response_body(string $label = null)
     * @method Show\Field|Collection period(string $label = null)
     * @method Show\Field|Collection week(string $label = null)
     * @method Show\Field|Collection section(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection week_period(string $label = null)
     * @method Show\Field|Collection teacher(string $label = null)
     * @method Show\Field|Collection location(string $label = null)
     * @method Show\Field|Collection student_password(string $label = null)
     * @method Show\Field|Collection student_name(string $label = null)
     * @method Show\Field|Collection identity_no(string $label = null)
     * @method Show\Field|Collection birth_date(string $label = null)
     * @method Show\Field|Collection gender(string $label = null)
     * @method Show\Field|Collection nation(string $label = null)
     * @method Show\Field|Collection education(string $label = null)
     * @method Show\Field|Collection college(string $label = null)
     * @method Show\Field|Collection major(string $label = null)
     * @method Show\Field|Collection class(string $label = null)
     * @method Show\Field|Collection grade(string $label = null)
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
