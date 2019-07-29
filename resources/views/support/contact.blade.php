@extends('layout.master')

@section('page.title', 'Contact Us')

@section('content')
    <div class="row">
        <div class="col">
            <div id="map"
                 style="width: 100%; height: 252px; background: rgb(238, 238, 238) none repeat scroll 0% 0%; border: 1px solid white; position: relative; overflow: hidden;">
                <div
                    style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                    <div
                        style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;"
                        class="gm-style">
                        <div
                            style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: none;"
                            tabindex="0">
                            <div
                                style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                <div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                        <div style="position: absolute; transform: matrix(1, 0, 0, 1, -251, -26);">
                                            <div
                                                style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 768px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: 768px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                            <div
                                                style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px;">
                                                <div style="width: 256px; height: 256px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                <div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                <div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;">
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: -1;">
                                        <div
                                            style="position: absolute; transform: matrix(1, 0, 0, 1, -251, -26); z-index: 987;">
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: -256px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 256px; top: -256px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 512px; top: -256px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 512px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -256px; top: -256px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 768px; top: -256px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 768px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: 0px;"></div>
                                            <div
                                                style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: -512px; top: -256px;"></div>
                                        </div>
                                    </div>
                                    <div
                                        style="width: 27px; height: 43px; overflow: hidden; position: absolute; left: -14px; top: -43px; z-index: 0;">
                                        <img
                                            style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                            alt=""
                                            src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png"
                                            draggable="false"></div>
                                </div>
                                <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                    <div
                                        style="position: absolute; transform: matrix(1, 0, 0, 1, -251, -26); z-index: 987;">
                                        <div
                                            style="position: absolute; left: 256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4057!3i2682!4i256!2m3!1e0!2sm!3i446151502!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=123099">
                                        </div>
                                        <div
                                            style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4056!3i2682!4i256!2m3!1e0!2sm!3i446151502!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=118429">
                                        </div>
                                        <div
                                            style="position: absolute; left: 0px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4056!3i2681!4i256!2m3!1e0!2sm!3i446151334!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=77808">
                                        </div>
                                        <div
                                            style="position: absolute; left: 256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4057!3i2681!4i256!2m3!1e0!2sm!3i446151334!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=82478">
                                        </div>
                                        <div
                                            style="position: absolute; left: 512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4058!3i2681!4i256!2m3!1e0!2sm!3i446151334!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=87148">
                                        </div>
                                        <div
                                            style="position: absolute; left: 512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4058!3i2682!4i256!2m3!1e0!2sm!3i446151502!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=127769">
                                        </div>
                                        <div
                                            style="position: absolute; left: -256px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4055!3i2682!4i256!2m3!1e0!2sm!3i446151502!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=113759">
                                        </div>
                                        <div
                                            style="position: absolute; left: -256px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4055!3i2681!4i256!2m3!1e0!2sm!3i446151454!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=108824">
                                        </div>
                                        <div
                                            style="position: absolute; left: 768px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4059!3i2681!4i256!2m3!1e0!2sm!3i446151322!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=45100">
                                        </div>
                                        <div
                                            style="position: absolute; left: 768px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4059!3i2682!4i256!2m3!1e0!2sm!3i446151322!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=67324">
                                        </div>
                                        <div
                                            style="position: absolute; left: -512px; top: 0px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4054!3i2682!4i256!2m3!1e0!2sm!3i446151310!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=128327">
                                        </div>
                                        <div
                                            style="position: absolute; left: -512px; top: -256px; width: 256px; height: 256px; transition: opacity 200ms linear 0s;">
                                            <img
                                                style="width: 256px; height: 256px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                draggable="false" alt="" role="presentation"
                                                src="https://maps.googleapis.com/maps/vt?pb=!1m5!1m4!1i13!2i4054!3i2681!4i256!2m3!1e0!2sm!3i446151454!3m9!2sen-GB!3sUS!5e18!12m1!1e68!12m3!1e37!2m1!1ssmartmaps!4e0!23i1301875&amp;key=AIzaSyBPCYkrCvcpPgC9R09dsX7tOyNNNhx20iY&amp;token=104154">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;"
                                class="gm-style-pbc"><p class="gm-style-pbt"></p></div>
                            <div
                                style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                <div
                                    style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                    <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;">
                                        <div
                                            style="width: 27px; height: 43px; overflow: hidden; position: absolute; opacity: 0; left: -14px; top: -43px; z-index: 0;">
                                            <img
                                                style="position: absolute; left: 0px; top: 0px; width: 27px; height: 43px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none;"
                                                alt=""
                                                src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png"
                                                draggable="false" usemap="#gmimap1">
                                            <map name="gmimap1" id="gmimap1">
                                                <area log="miw" coords="13.5,0,4,3.75,0,13.5,13.5,43,27,13.5,23,3.75"
                                                      shape="poly" title=""
                                                      style="cursor: pointer; touch-action: none;">
                                            </map>
                                        </div>
                                    </div>
                                    <div
                                        style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <iframe aria-hidden="true"
                                style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: medium none;"
                                src="about:blank" frameborder="0"></iframe>
                        <div
                            style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;">
                            <a style="position: static; overflow: visible; float: none; display: inline;"
                               target="_blank" rel="noopener"
                               href="https://maps.google.com/maps?ll=52.640333,-1.714656&amp;z=13&amp;t=m&amp;hl=en-GB&amp;gl=US&amp;mapclient=apiv3"
                               title="Open this area in Google Maps (opens a new window)">
                                <div style="width: 66px; height: 26px; cursor: pointer;"><img
                                        style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px;"
                                        alt="" src="https://maps.gstatic.com/mapfiles/api-3/images/google4.png"
                                        draggable="false"></div>
                            </a></div>
                        <div
                            style="background-color: white; padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-sizing: border-box; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 300px; height: 180px; position: absolute; left: 404px; top: 35px;">
                            <div style="padding: 0px 0px 10px; font-size: 16px;">Map Data</div>
                            <div style="font-size: 13px;">Map data ©2018 Google</div>
                            <button
                                style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; border: 0px none; margin: 0px; padding: 0px; position: absolute; cursor: pointer; -moz-user-select: none; top: 0px; right: 0px; width: 37px; height: 37px;"
                                draggable="false" title="Close" aria-label="Close" type="button"
                                class="gm-ui-hover-effect"><img
                                    src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224px%22%20height%3D%2224px%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%23000000%22%3E%0A%20%20%20%20%3Cpath%20d%3D%22M19%206.41L17.59%205%2012%2010.59%206.41%205%205%206.41%2010.59%2012%205%2017.59%206.41%2019%2012%2013.41%2017.59%2019%2019%2017.59%2013.41%2012z%22%2F%3E%0A%20%20%20%20%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                    style="pointer-events: none; display: block; width: 13px; height: 13px; margin: 12px;">
                            </button>
                        </div>
                        <div class="gmnoprint"
                             style="z-index: 1000001; position: absolute; right: 161px; bottom: 0px; width: 114px;">
                            <div draggable="false" style="-moz-user-select: none; height: 14px; line-height: 14px;"
                                 class="gm-style-cc">
                                <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                    <div style="width: 1px;"></div>
                                    <div
                                        style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                                </div>
                                <div
                                    style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                    <a style="text-decoration: none; cursor: pointer; display: none;">Map Data</a><span>Map data ©2018 Google</span>
                                </div>
                            </div>
                        </div>
                        <div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;">
                            <div
                                style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">
                                Map data ©2018 Google
                            </div>
                        </div>
                        <div class="gmnoprint gm-style-cc"
                             style="z-index: 1000001; -moz-user-select: none; height: 14px; line-height: 14px; position: absolute; right: 95px; bottom: 0px;"
                             draggable="false">
                            <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                <div style="width: 1px;"></div>
                                <div
                                    style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                            </div>
                            <div
                                style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                <a style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);"
                                   href="https://www.google.com/intl/en-GB_US/help/terms_maps.html" target="_blank"
                                   rel="noopener">Terms of Use</a></div>
                        </div>
                        <button
                            style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; margin: 10px; padding: 0px; position: absolute; cursor: pointer; -moz-user-select: none; border-radius: 2px; height: 40px; width: 40px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; overflow: hidden; top: 0px; right: 0px;"
                            draggable="false" title="Toggle fullscreen view" aria-label="Toggle fullscreen view"
                            type="button" class="gm-control-active gm-fullscreen-control"><img
                                style="height: 18px; width: 18px; margin: 11px;"
                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%20018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                style="height: 18px; width: 18px; margin: 11px;"
                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                style="height: 18px; width: 18px; margin: 11px;"
                                src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C0v2v4h2V2h4V0H2H0z%20M16%2C0h-4v2h4v4h2V2V0H16z%20M16%2C16h-4v2h4h2v-2v-4h-2V16z%20M2%2C12H0v4v2h2h4v-2H2V12z%22%2F%3E%0A%3C%2Fsvg%3E%0A">
                        </button>
                        <div draggable="false"
                             style="-moz-user-select: none; height: 14px; line-height: 14px; position: absolute; right: 0px; bottom: 0px;"
                             class="gm-style-cc">
                            <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                <div style="width: 1px;"></div>
                                <div
                                    style="background-color: rgb(245, 245, 245); width: auto; height: 100%; margin-left: 1px;"></div>
                            </div>
                            <div
                                style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right; vertical-align: middle; display: inline-block;">
                                <a target="_blank" rel="noopener"
                                   title="Report errors in the road map or imagery to Google"
                                   style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;"
                                   href="https://www.google.com/maps/@52.6403333,-1.7146557,13z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3">Report
                                    a map error</a></div>
                        </div>
                        <div class="gmnoprint gm-bundled-control gm-bundled-control-on-bottom"
                             style="margin: 10px; -moz-user-select: none; position: absolute; bottom: 167px; right: 40px;"
                             draggable="false" controlwidth="40" controlheight="153">
                            <div class="gmnoprint" style="position: absolute; left: 0px; top: 72px;" controlwidth="40"
                                 controlheight="81">
                                <div draggable="false"
                                     style="-moz-user-select: none; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; cursor: pointer; background-color: rgb(255, 255, 255); width: 40px; height: 81px;">
                                    <button
                                        style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; border: 0px none; margin: 0px; padding: 0px; position: relative; cursor: pointer; -moz-user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"
                                        draggable="false" title="Zoom in" aria-label="Zoom in" type="button"
                                        class="gm-control-active"><img
                                            style="height: 18px; width: 18px; margin: 9px 11px 13px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23666%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 18px; width: 18px; margin: 9px 11px 13px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23333%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 18px; width: 18px; margin: 9px 11px 13px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpolygon%20fill%3D%22%23111%22%20points%3D%2218%2C7%2011%2C7%2011%2C0%207%2C0%207%2C7%200%2C7%200%2C11%207%2C11%207%2C18%2011%2C18%2011%2C11%2018%2C11%22%2F%3E%0A%3C%2Fsvg%3E%0A">
                                    </button>
                                    <div
                                        style="position: relative; overflow: hidden; width: 30px; height: 1px; margin: 0px 5px; background-color: rgb(230, 230, 230); top: 0px;"></div>
                                    <button
                                        style="background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; border: 0px none; margin: 0px; padding: 0px; position: relative; cursor: pointer; -moz-user-select: none; overflow: hidden; width: 40px; height: 40px; top: 0px; left: 0px;"
                                        draggable="false" title="Zoom out" aria-label="Zoom out" type="button"
                                        class="gm-control-active"><img
                                            style="height: 18px; width: 18px; margin: 13px 11px 9px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 18px; width: 18px; margin: 13px 11px 9px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 18px; width: 18px; margin: 13px 11px 9px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218%22%20height%3D%2218%22%20viewBox%3D%220%200%2018%2018%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C7h18v4H0V7z%22%2F%3E%0A%3C%2Fsvg%3E%0A">
                                    </button>
                                </div>
                            </div>
                            <div class="gm-svpc"
                                 style="background-color: rgb(255, 255, 255); box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px; width: 40px; height: 40px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: none; position: absolute; left: 0px; top: 0px;"
                                 controlwidth="40" controlheight="40">
                                <div style="position: absolute; left: 50%; top: 50%;"></div>
                                <div style="position: absolute; left: 50%; top: 50%;"><img
                                        src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2223%22%20height%3D%2238%22%20viewBox%3D%220%200%2023%2038%22%3E%0A%3Cpath%20d%3D%22M16.6%2C38.1h-5.5l-0.2-2.9-0.2%2C2.9h-5.5L5%2C25.3l-0.8%2C2a1.53%2C1.53%2C0%2C0%2C1-1.9.9l-1.2-.4a1.58%2C1.58%2C0%2C0%2C1-1-1.9v-0.1c0.3-.9%2C3.1-11.2%2C3.1-11.2a2.66%2C2.66%2C0%2C0%2C1%2C2.3-2l0.6-.5a6.93%2C6.93%2C0%2C0%2C1%2C4.7-12%2C6.8%2C6.8%2C0%2C0%2C1%2C4.9%2C2%2C7%2C7%2C0%2C0%2C1%2C2%2C4.9%2C6.65%2C6.65%2C0%2C0%2C1-2.2%2C5l0.7%2C0.5a2.78%2C2.78%2C0%2C0%2C1%2C2.4%2C2s2.9%2C11.2%2C2.9%2C11.3a1.53%2C1.53%2C0%2C0%2C1-.9%2C1.9l-1.3.4a1.63%2C1.63%2C0%2C0%2C1-1.9-.9l-0.7-1.8-0.1%2C12.7h0Zm-3.6-2h1.7L14.9%2C20.3l1.9-.3%2C2.4%2C6.3%2C0.3-.1c-0.2-.8-0.8-3.2-2.8-10.9a0.63%2C0.63%2C0%2C0%2C0-.6-0.5h-0.6l-1.1-.9h-1.9l-0.3-2a4.83%2C4.83%2C0%2C0%2C0%2C3.5-4.7A4.78%2C4.78%200%200%2C0%2011%202.3H10.8a4.9%2C4.9%2C0%2C0%2C0-1.4%2C9.6l-0.3%2C2h-1.9l-1%2C.9h-0.6a0.74%2C0.74%2C0%2C0%2C0-.6.5c-2%2C7.5-2.7%2C10-3%2C10.9l0.3%2C0.1%2C2.5-6.3%2C1.9%2C0.3%2C0.2%2C15.8h1.6l0.6-8.4a1.52%2C1.52%2C0%2C0%2C1%2C1.5-1.4%2C1.5%2C1.5%2C0%2C0%2C1%2C1.5%2C1.4l0.9%2C8.4h0Zm-10.9-9.6h0Zm17.5-.1h0Z%22%20style%3D%22fill%3A%23333%3Bopacity%3A0.7%3Bisolation%3Aisolate%22%2F%3E%0A%3Cpath%20d%3D%22M5.9%2C13.6l1.1-.9h7.8l1.2%2C0.9%22%20style%3D%22fill%3A%23ce592c%22%2F%3E%0A%3Cellipse%20cx%3D%2210.9%22%20cy%3D%2213.1%22%20rx%3D%222.7%22%20ry%3D%220.3%22%20style%3D%22fill%3A%23ce592c%3Bopacity%3A0.5%3Bisolation%3Aisolate%22%2F%3E%0A%3Cpath%20d%3D%22M20.6%2C26.1l-2.9-11.3a1.71%2C1.71%2C0%2C0%2C0-1.6-1.2H5.7a1.69%2C1.69%2C0%2C0%2C0-1.5%2C1.3l-3.1%2C11.3a0.61%2C0.61%2C0%2C0%2C0%2C.3.7l1.1%2C0.4a0.61%2C0.61%2C0%2C0%2C0%2C.7-0.3l2.7-6.7%2C0.2%2C16.8h3.6l0.6-9.3a0.47%2C0.47%2C0%2C0%2C1%2C.44-0.5h0.06c0.4%2C0%2C.4.2%2C0.5%2C0.5l0.6%2C9.3h3.6L15.7%2C20.3l2.5%2C6.6a0.52%2C0.52%2C0%2C0%2C0%2C.66.31h0l1.2-.4a0.57%2C0.57%2C0%2C0%2C0%2C.5-0.7h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%2F%3E%0A%3Cpath%20d%3D%22M7%2C13.6l3.9%2C6.7%2C3.9-6.7%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%2F%3E%0A%3Ccircle%20cx%3D%2210.9%22%20cy%3D%227%22%20r%3D%225.9%22%20style%3D%22fill%3A%23fdbf2d%22%2F%3E%0A%3C%2Fsvg%3E%0A"
                                        style="width: 18px; height: 30px; position: absolute; left: -9px; top: -15px; pointer-events: none;"
                                        aria-label="Street View Pegman Control"><img
                                        src="data:image/svg+xml,%3Csvg%20width%3D%2224px%22%20height%3D%2238px%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2024%2038%22%3E%0A%3Cpath%20d%3D%22M22%2C26.6l-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L6.6%2C21l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Z%22%20style%3D%22fill%3A%23333%3Bfill-opacity%3A0.2%22%2F%3E%22%0A%3C%2Fsvg%3E%0A%0A"
                                        style="display: none; width: 18px; height: 30px; position: absolute; left: -9px; top: -15px; pointer-events: none;"
                                        aria-label="Pegman is on top of the Map"><img
                                        style="display: none; width: 32px; height: 40px; position: absolute; left: -18px; top: -18px; pointer-events: none;"
                                        src="data:image/svg+xml,%3Csvg%20width%3D%2240px%22%20height%3D%2250px%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2040%2050%22%3E%0A%3Cpath%20d%3D%22M34.00%2C-30.40l-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L18.60%2C-36.00l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Zm1.2%2C59.1-2.9-11.3a2.78%2C2.78%2C0%2C0%2C0-2.4-2l-0.7-.5a6.82%2C6.82%2C0%2C0%2C0%2C2.2-5%2C6.9%2C6.9%2C0%2C0%2C0-13.8%2C0%2C7%2C7%2C0%2C0%2C0%2C2.2%2C5.1l-0.6.5a2.55%2C2.55%2C0%2C0%2C0-2.3%2C2s-3%2C11.1-3%2C11.2v0.1a1.58%2C1.58%2C0%2C0%2C0%2C1%2C1.9l1.2%2C0.4a1.63%2C1.63%2C0%2C0%2C0%2C1.9-.9l0.8-2%2C0.2%2C12.8h11.3l0.2-12.6%2C0.7%2C1.8a1.54%2C1.54%2C0%2C0%2C0%2C1.5%2C1%2C1.09%2C1.09%2C0%2C0%2C0%2C.5-0.1l1.3-.4a1.85%2C1.85%2C0%2C0%2C0%2C.7-2h0Zm-1.2.9-1.2.4a0.61%2C0.61%2C0%2C0%2C1-.7-0.3l-2.5-6.6-0.2%2C16.8h-9.4L18.60%2C24.00l-2.7%2C6.7a0.52%2C0.52%2C0%2C0%2C1-.66.31h0l-1.1-.4a0.52%2C0.52%2C0%2C0%2C1-.31-0.66v0l3.1-11.3a1.69%2C1.69%2C0%2C0%2C1%2C1.5-1.3h0.2l1-.9h2.3a5.9%2C5.9%2C0%2C1%2C1%2C3.2%2C0h2.3l1.1%2C0.9h0.2a1.71%2C1.71%2C0%2C0%2C1%2C1.6%2C1.2l2.9%2C11.3a0.84%2C0.84%2C0%2C0%2C1-.4.7h0Z%22%20style%3D%22fill%3A%23333%3Bfill-opacity%3A0.2%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M15.40%2C38.80h-4a1.64%2C1.64%2C0%2C0%2C1-1.4-1.1l-3.1-8a0.9%2C0.9%2C0%2C0%2C1-.5.1l-1.4.1a1.62%2C1.62%2C0%2C0%2C1-1.6-1.4l-1.1-13.1%2C1.6-1.3a6.87%2C6.87%2C0%2C0%2C1-3-4.6A7.14%2C7.14%200%200%2C1%202%204a7.6%2C7.6%2C0%2C0%2C1%2C4.7-3.1%2C7.14%2C7.14%2C0%2C0%2C1%2C5.5%2C1.1%2C7.28%2C7.28%2C0%2C0%2C1%2C2.3%2C9.6l2.1-.1%2C0.1%2C1c0%2C0.2.1%2C0.5%2C0.1%2C0.8a2.41%2C2.41%2C0%2C0%2C1%2C1%2C1s1.9%2C3.2%2C2.8%2C4.9c0.7%2C1.2%2C2.1%2C4.2%2C2.8%2C5.9a2.1%2C2.1%2C0%2C0%2C1-.8%2C2.6l-0.6.4a1.63%2C1.63%2C0%2C0%2C1-1.5.2l-0.6-.3a8.93%2C8.93%2C0%2C0%2C0%2C.5%2C1.3%2C7.91%2C7.91%2C0%2C0%2C0%2C1.8%2C2.6l0.6%2C0.3v4.6l-4.5-.1a7.32%2C7.32%2C0%2C0%2C1-2.5-1.5l-0.4%2C3.6h0Zm-10-19.2%2C3.5%2C9.8%2C2.9%2C7.5h1.6V35l-1.9-9.4%2C3.1%2C5.4a8.24%2C8.24%2C0%2C0%2C0%2C3.8%2C3.8h2.1v-1.4a14%2C14%2C0%2C0%2C1-2.2-3.1%2C44.55%2C44.55%2C0%2C0%2C1-2.2-8l-1.3-6.3%2C3.2%2C5.6c0.6%2C1.1%2C2.1%2C3.6%2C2.8%2C4.9l0.6-.4c-0.8-1.6-2.1-4.6-2.8-5.8-0.9-1.7-2.8-4.9-2.8-4.9a0.54%2C0.54%2C0%2C0%2C0-.4-0.3l-0.7-.1-0.1-.7a4.33%2C4.33%2C0%2C0%2C0-.1-0.5l-5.3.3%2C2.2-1.9a4.3%2C4.3%2C0%2C0%2C0%2C.9-1%2C5.17%2C5.17%2C0%2C0%2C0%2C.8-4%2C5.67%2C5.67%2C0%2C0%2C0-2.2-3.4%2C5.09%2C5.09%2C0%2C0%2C0-4-.8%2C5.67%2C5.67%2C0%2C0%2C0-3.4%2C2.2%2C5.17%2C5.17%2C0%2C0%2C0-.8%2C4%2C5.67%2C5.67%2C0%2C0%2C0%2C2.2%2C3.4%2C3.13%2C3.13%2C0%2C0%2C0%2C1%2C.5l1.6%2C0.6-3.2%2C2.6%2C1%2C11.5h0.4l-0.3-8.2h0Z%22%20style%3D%22fill%3A%23333%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M3.35%2C15.90l1.1%2C12.5a0.39%2C0.39%2C0%2C0%2C0%2C.36.42l0.14%2C0%2C1.4-.1a0.66%2C0.66%2C0%2C0%2C0%2C.5-0.4l-0.2-3.8-3.3-8.6h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M5.20%2C28.80l1.1-.1a0.66%2C0.66%2C0%2C0%2C0%2C.5-0.4l-0.2-3.8-1.2-3.1Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M21.40%2C35.70l-3.8-1.2-2.7-7.8L12.00%2C15.5l3.4-2.9c0.2%2C2.4%2C2.2%2C14.1%2C3.7%2C17.1%2C0%2C0%2C1.3%2C2.6%2C2.3%2C3.1v2.9m-8.4-8.1-2-.3%2C2.5%2C10.1%2C0.9%2C0.4v-2.9%22%20style%3D%22fill%3A%23e5892b%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M17.80%2C25.40c-0.4-1.5-.7-3.1-1.1-4.8-0.1-.4-0.1-0.7-0.2-1.1l-1.1-2-1.7-1.6s0.9%2C5%2C2.4%2C7.1a19.12%2C19.12%2C0%2C0%2C0%2C1.7%2C2.4h0Z%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M14.40%2C37.80h-3a0.43%2C0.43%2C0%2C0%2C1-.4-0.4l-3-7.8-1.7-4.8-3-9%2C8.9-.4s2.9%2C11.3%2C4.3%2C14.4c1.9%2C4.1%2C3.1%2C4.7%2C5%2C5.8h-3.2s-4.1-1.2-5.9-7.7a0.59%2C0.59%2C0%2C0%2C0-.6-0.4%2C0.62%2C0.62%2C0%2C0%2C0-.3.7s0.5%2C2.4.9%2C3.6a34.87%2C34.87%2C0%2C0%2C0%2C2%2C6h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M15.40%2C12.70l-3.3%2C2.9-8.9.4%2C3.3-2.7%22%20style%3D%22fill%3A%23ce592b%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M9.10%2C21.10l1.4-6.2-5.9.5%22%20style%3D%22fill%3A%23cf572e%3Bopacity%3A0.6%3Bisolation%3Aisolate%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M12.00%2C13.5a4.75%2C4.75%2C0%2C0%2C1-2.6%2C1.1c-1.5.3-2.9%2C0.2-2.9%2C0s1.1-.6%2C2.7-1%22%20style%3D%22fill%3A%23bb3d19%22%3E%3C%2Fpath%3E%0A%3Ccircle%20cx%3D%227.92%22%20cy%3D%228.19%22%20r%3D%226.3%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fcircle%3E%0A%3Cpath%20d%3D%22M4.70%2C13.60a6.21%2C6.21%2C0%2C0%2C0%2C8.4-1.9v-0.1a8.89%2C8.89%2C0%2C0%2C1-8.4%2C2h0Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M21.20%2C27.20l0.6-.4a1.09%2C1.09%2C0%2C0%2C0%2C.4-1.3c-0.7-1.5-2.1-4.6-2.8-5.8-0.9-1.7-2.8-4.9-2.8-4.9a1.6%2C1.6%2C0%2C0%2C0-2.17-.65l-0.23.15a1.68%2C1.68%2C0%2C0%2C0-.4%2C2.1s2.3%2C3.9%2C3.1%2C5.3c0.6%2C1%2C2.1%2C3.7%2C2.9%2C5.1a0.94%2C0.94%2C0%2C0%2C0%2C1.24.49l0.16-.09h0Z%22%20style%3D%22fill%3A%23fdbf2d%22%3E%3C%2Fpath%3E%0A%3Cpath%20d%3D%22M19.40%2C19.80c-0.9-1.7-2.8-4.9-2.8-4.9a1.6%2C1.6%2C0%2C0%2C0-2.17-.65l-0.23.15-0.3.3c1.1%2C1.5%2C2.9%2C3.8%2C3.9%2C5.4%2C1.1%2C1.8%2C2.9%2C5%2C3.8%2C6.7l0.1-.1a1.09%2C1.09%2C0%2C0%2C0%2C.4-1.3%2C57.67%2C57.67%2C0%2C0%2C0-2.7-5.6h0Z%22%20style%3D%22fill%3A%23ce592b%3Bfill-opacity%3A0.25%22%3E%3C%2Fpath%3E%0A%3C%2Fsvg%3E%0A"
                                        aria-label="Street View Pegman Control"></div>
                            </div>
                            <div class="gmnoprint" controlwidth="40" controlheight="40"
                                 style="display: none; position: absolute;">
                                <div style="width: 40px; height: 40px;">
                                    <button
                                        style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: none; border: 0px none; margin: 0px 0px 32px; padding: 0px; position: relative; cursor: pointer; -moz-user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"
                                        draggable="false" title="Rotate map 90 degrees"
                                        aria-label="Rotate map 90 degrees" type="button" class="gm-control-active"><img
                                            style="height: 28px; width: 28px; margin: 6px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 28px; width: 28px; margin: 6px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="height: 28px; width: 28px; margin: 6px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2222%22%20viewBox%3D%220%200%2024%2022%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20fill-rule%3D%22evenodd%22%20d%3D%22M20%2010c0-5.52-4.48-10-10-10s-10%204.48-10%2010v5h5v-5c0-2.76%202.24-5%205-5s5%202.24%205%205v5h-4l6.5%207%206.5-7h-4v-5z%22%20clip-rule%3D%22evenodd%22%2F%3E%0A%3C%2Fsvg%3E%0A">
                                    </button>
                                    <button
                                        style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: block; border: 0px none; margin: 0px; padding: 0px; position: relative; cursor: pointer; -moz-user-select: none; width: 40px; height: 40px; top: 0px; left: 0px; overflow: hidden; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; border-radius: 2px;"
                                        draggable="false" title="Tilt map" aria-label="Tilt map" type="button"
                                        class="gm-tilt gm-control-active"><img
                                            style="width: 18px; height: 16px; margin: 12px 11px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23666%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="width: 18px; height: 16px; margin: 12px 11px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23333%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A"><img
                                            style="width: 18px; height: 16px; margin: 12px 11px;"
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2218px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2018%2016%22%3E%0A%20%20%3Cpath%20fill%3D%22%23111%22%20d%3D%22M0%2C16h8V9H0V16z%20M10%2C16h8V9h-8V16z%20M0%2C7h8V0H0V7z%20M10%2C0v7h8V0H10z%22%2F%3E%0A%3C%2Fsvg%3E%0A">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="gmnoprint"
                             style="margin: 10px; z-index: 0; position: absolute; cursor: pointer; left: 0px; top: 0px;">
                            <div style="float: left; position: relative;" class="gm-style-mtc">
                                <div role="button" tabindex="0" title="Show street map" aria-label="Show street map"
                                     aria-pressed="true"
                                     style="direction: ltr; overflow: hidden; text-align: center; height: 40px; display: table-cell; vertical-align: middle; position: relative; color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; -moz-user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 0px 17px; border-bottom-left-radius: 2px; border-top-left-radius: 2px; background-clip: padding-box; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; min-width: 35px; font-weight: 500;"
                                     draggable="false">Map
                                </div>
                                <div
                                    style="background-color: white; z-index: -1; padding: 2px; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; left: 0px; top: 40px; text-align: left; display: none;">
                                    <div
                                        style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; -moz-user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 6px 8px 6px 6px; direction: ltr; text-align: left; white-space: nowrap;"
                                        draggable="false" title="Show street map with terrain"><span role="checkbox"
                                                                                                     style="box-sizing: border-box; position: relative; line-height: 0; font-size: 0px; margin: 0px 5px 0px 0px; display: inline-block; background-color: rgb(255, 255, 255); border: 1px solid rgb(198, 198, 198); border-radius: 1px; width: 13px; height: 13px; vertical-align: middle;"><div
                                                style="position: absolute; left: 1px; top: -2px; width: 13px; height: 11px; overflow: hidden; display: none;"><img
                                                    style="position: absolute; left: -52px; top: -44px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none; width: 68px; height: 67px;"
                                                    alt="" src="https://maps.gstatic.com/mapfiles/mv/imgs8.png"
                                                    draggable="false"></div></span><label
                                            style="vertical-align: middle; cursor: pointer;">Terrain</label></div>
                                </div>
                            </div>
                            <div style="float: left; position: relative;" class="gm-style-mtc">
                                <div role="button" tabindex="0" title="Show satellite imagery"
                                     aria-label="Show satellite imagery" aria-pressed="false"
                                     style="direction: ltr; overflow: hidden; text-align: center; height: 40px; display: table-cell; vertical-align: middle; position: relative; color: rgb(86, 86, 86); font-family: Roboto, Arial, sans-serif; -moz-user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 0px 17px; border-bottom-right-radius: 2px; border-top-right-radius: 2px; background-clip: padding-box; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; min-width: 64px; border-left: 0px none;"
                                     draggable="false">Satellite
                                </div>
                                <div
                                    style="background-color: white; z-index: -1; padding: 2px; border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px; position: absolute; right: 0px; top: 40px; text-align: left; display: none;">
                                    <div
                                        style="color: rgb(0, 0, 0); font-family: Roboto, Arial, sans-serif; -moz-user-select: none; font-size: 18px; background-color: rgb(255, 255, 255); padding: 6px 8px 6px 6px; direction: ltr; text-align: left; white-space: nowrap;"
                                        draggable="false" title="Show imagery with street names"><span role="checkbox"
                                                                                                       style="box-sizing: border-box; position: relative; line-height: 0; font-size: 0px; margin: 0px 5px 0px 0px; display: inline-block; background-color: rgb(255, 255, 255); border: 1px solid rgb(198, 198, 198); border-radius: 1px; width: 13px; height: 13px; vertical-align: middle;"><div
                                                style="position: absolute; left: 1px; top: -2px; width: 13px; height: 11px; overflow: hidden;"><img
                                                    style="position: absolute; left: -52px; top: -44px; -moz-user-select: none; border: 0px none; padding: 0px; margin: 0px; max-width: none; width: 68px; height: 67px;"
                                                    alt="" src="https://maps.gstatic.com/mapfiles/mv/imgs8.png"
                                                    draggable="false"></div></span><label
                                            style="vertical-align: middle; cursor: pointer;">Labels</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card card-body">
                <div class="address">
                    <span>{{ env('ADDRESS_LINE_1') }}</span>
                    <span>{{ env('ADDRESS_LINE_2') }}</span>
                    <span>{{ env('ADDRESS_LINE_3') }}</span>
                    <span>{{ env('ADDRESS_LINE_4') }}</span>
                    <span>{{ env('ADDRESS_LINE_5') }}</span>
                    <span>{{ env('ADDRESS_POSTCODE') }}</span>

                    <br>

                    <span>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' . env('ADDRESS_TELEPHONE') : '' }}</span>
                    <span>{{ env('ADDRESS_FAX') ? 'Fax: ' . env('ADDRESS_FAX') : '' }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-body">
                <form action="">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">To:</label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->email }}">{{ $contact->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name:</label>
                        <div class="col-sm-10">
                            <input class="form-control"
                                   value="{{ Auth::user() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : '' }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email:</label>
                        <div class="col-sm-10">
                            <input class="form-control" value="{{ Auth::user() ? Auth::user()->email : '' }}">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label">Message:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
