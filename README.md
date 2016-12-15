# MX_WidgetComponent
Useful module to implement widget components that don't exist in Magento 2.

Currently 4 types of component can be defined: 
- Image Picker 
- Date Picker
- Datetime Picker
- Textarea

##Compatibility
Magento 2.X


## Usage

### Image Picker

widget.xml
```
<parameter name="imagepicker_id" xsi:type="block" visible="true" required="false">
    <label translate="true">Image</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\ImagePicker" />
        <!-- Optional configuration parameters -->
        <data>
            <item name="dimension" xsi:type="array">
                <item name="max-width" xsi:type="string">500</item>
                <item name="max-height" xsi:type="string">500</item>
            </item>
            <item name="max-size" xsi:type="string">50000</item>
            <item name="button" xsi:type="array">
                <item name="open" xsi:type="string">Select Image...</item>
            </item>
        </data>
        <!-- Optional configuration parameters -->
    </block>
</parameter>
```

### Date Picker

widget.xml
```
<parameter name="date_id" xsi:type="block" visible="true" required="false">
    <label translate="true">Date</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\DatePicker">
        <!-- Optional configuration parameters -->
        <data>
            <item name="dateFormat" xsi:type="string">Y-m-d</item>
            <item name="timeFormat" xsi:type="string">H:i</item>
            <item name="image" xsi:type="string">path-to/url</item>
            <item name="disabled" xsi:type="boolean">true</item>
        </data>
        <!-- Optional configuration parameters -->
    </block>
</parameter>
```

If timeFormat is set it will be implemented as a DateTimePicker.


### Datetime Picker

widget.xml
```
<parameter name="datetime_id" xsi:type="block" visible="true" required="false">
    <label translate="true">Datetime</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\DateTimePicker">
        <!-- Optional configuration parameters -->
        <data>
            <item name="dateFormat" xsi:type="string">Y-m-d</item>
            <item name="timeFormat" xsi:type="string">H:i</item>
            <item name="image" xsi:type="string">path-to/url</item>
            <item name="disabled" xsi:type="boolean">true</item>
        </data>
        <!-- Optional configuration parameters -->
    </block>
</parameter>
```

### Textarea

widget.xml
```
<parameter name="textarea_id" xsi:type="block" visible="true" required="false">
    <label translate="true">Textarea</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\Textarea" />
</parameter>
```
