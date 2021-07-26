<?php
/**
 * @file
 * @ingroup PF
 */

/**
 * @ingroup PFFormInput
 */
class PFTimeInput extends PFFormInput {

    public static function getName(): string {
        return 'time';
    }

    public static function getDefaultPropTypes() {
        return [];
    }

    public static function getOtherPropTypesHandled() {
        return [ '_dat' ];
    }

    public static function getDefaultCargoTypes() {
        return [
            'Time' => []
        ];
    }

    public static function getHTML( $time, $input_name, $is_mandatory, $is_disabled, array $other_args ) {
        global $wgPageFormsTabIndex, $wgPageForms24HourTime;

        if ( $time ) {
            // Can show up here either as an array or a string,
            // depending on whether it came from user input or a
            // wiki page.
            if ( is_array( $time ) ) {
                if ( isset( $time['hour'] ) ) {
                    $hour = $time['hour'];
                }
                if ( isset( $time['minute'] ) ) {
                    $minute = $time['minute'];
                }
                if ( isset( $time['second'] ) ) {
                    $second = $time['second'];
                }
            } else {
                // Parse the date.
                // We get only the time data here - the main
                // date data is handled by the call to
                // parent::getMainHTML().

                // Handle 'default=now'.
                //if ( $time == 'now' ) {
                 //   $dateTimeObject = new DateTime( 'now' );
                //} else {
                    //$dateTimeObject = new DateTime( $time );
                    //$dateTimeObject = DateTime::createFromFormat('G:i:s.v', $time);
                //}
                $dateTimeObject = DateTime::createFromFormat('G:i:s.v', $time);
                //$dateTimeObject = DateTime::createFromFormat('G:i:s.v', '21:56:43.355');
                //echo $time;
                //echo $dateTimeObject->format('G:i:s.v');
                $hour = $dateTimeObject->format( 'G' );
                $minute = $dateTimeObject->format( 'i' );
                $second = $dateTimeObject->format( 's' );
                $millisecond = $dateTimeObject->format( 'v' );
            }
        } else {
            $hour = '00';
            $minute = '00';
            $second = '00'; // default at least this value
            $millisecond = '000';

        }

        //echo "HELLO";
        $text = '';
        $disabled_text = ( $is_disabled ) ? 'disabled' : '';
        $text .= 'Hours:<input tabindex="' . $wgPageFormsTabIndex . '" name="' . $input_name . '[hour]" type="text" class="hoursInput" value="' . $hour . '" size="2"/ ' . $disabled_text . '>';
        $wgPageFormsTabIndex++;
        $text .= 'Minutes:<input tabindex="' . $wgPageFormsTabIndex . '" name="' . $input_name . '[minute]" type="text" class="minutesInput" value="' . $minute . '" size="2"/ ' . $disabled_text . '>';
        $wgPageFormsTabIndex++;
        $text .= 'Seconds:<input tabindex="' . $wgPageFormsTabIndex . '" name="' . $input_name . '[second]" type="text" class="secondsInput" value="' . $second . '" size="2"/ ' . $disabled_text . '>';
        $wgPageFormsTabIndex++;
        $text .= 'Milliseconds:<input tabindex="' . $wgPageFormsTabIndex . '" name="' . $input_name . '[millisecond]" type="text" class="millisecondsInput" value="' . $millisecond . '" size="2"/ ' . $disabled_text . '>' . "\n";

        return $text;
    }

    public static function getParameters() {
        $params = parent::getParameters();
        $params[] = [
            'name' => 'include timezone',
            'type' => 'boolean',
            'description' => wfMessage( 'pf_forminputs_includetimezone' )->text()
        ];
        return $params;
    }

    /**
     * Returns the HTML code to be included in the output page for this input.
     * @return string
     */
    public function getHtmlText(): string {
        return self::getHTML(
            $this->mCurrentValue,
            $this->mInputName,
            $this->mIsMandatory,
            $this->mIsDisabled,
            $this->mOtherArgs
        );
    }
}
