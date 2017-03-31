# MX_WidgetComponent

The module provides useful widget components to be able to create complex widgets in Magento 2.

## List of available components

### Image Picker
Allows to use the cms image uploader on the widget forms, which makes it easy to upload/select an image for the widget.

Features of this component:
- Upload cms image
- Select already uploaded cms image
- Configurable image choose button label
- Restrict the allowed images by with/height
- Restrict the allowed images by file size
- (allowed file types are configured in the cms module OOB)

### Date Picker
Allows to pick date using the default datepicker js component.

Features of this component:
- Date format is configurable
- Time format is configurable (if not provided only date chooser will appear)
- Image of the date-picker component is configurable
- Date field can be configured to be disabled (read-only)

### Datetime Picker
Same as the datepicker component, just comes with a pre-configured time format, so it will appear as a date-time chooser by default.

### Textarea
Allows to use textarea on the widget forms.

Features of this component:
- Visible width of a text area (cols) is configurable
- Visible number of lines in a text area (rows) is configurable
- Maximum number of characters allowed (maxlenght) is configurable
- Dinamically shows the number of characters remaining if maxlength configured

### Checkbox
Allows to use checkboxes on the widget form. Useful for replacing the Yes/No select which usually used.

Features of this component:
- The checkbox value is configurable (by default it is '1' when checked)

### SubWidget
Allows to embed a widget into another widget. Useful to create custom reusable widget components. E.g. a link sub-widget which is a combination of 3 fields: url, link text and 'should open in new window' can be reused in many widget.

Features of this component:
- The label of the sub-widget cofiguration button is configurable
- Allows to embed widget in any depth (sub-widget can also have a sub-widget)


For more information please see the Usage section.

## Compatibility
Magento 2.X (tested in magento 2.0.10, 2.1.2)

## Usage

### Image Picker

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="false">
    <label translate="true">Image</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\ImagePicker">
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

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="false">
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

### Datetime Picker

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="false">
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

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="false">
    <label translate="true">Textarea</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\Textarea">
        <!-- Optional configuration parameters -->
        <data>
            <item name="cols" xsi:type="string">visible width of a text area</item>
            <item name="rows" xsi:type="string">visible number of lines in a text area</item>
            <item name="maxlength" xsi:type="string">maximum number of characters allowed in the text area</item>
        </data>
        <!-- Optional configuration parameters -->
    </block>
</parameter>
```

### Checkbox

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="false">
    <label translate="true">Checkbox</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\Checkbox">
        <!-- Optional configuration parameters -->
        <data>
            <item name="value" xsi:type="string">checkbox_value</item>
        </data>
        <!-- Optional configuration parameters -->
    </block>
</parameter>
```
### SubWidget

```xml
<parameter name="my_param" xsi:type="block" visible="true" required="true" sort_order="10">
    <label translate="true">Sub-Widget</label>
    <block class="MX\WidgetComponent\Block\Adminhtml\Component\SubWidget">
        <data>
            <!-- Optional configuration parameters -->
            <item name="button-label" xsi:type="string">Subwidget configuration button text</item>
            <!-- Optional configuration parameters -->
            <item name="widget-type-id" xsi:type="string">the_id_of_the_sub_widget</item>
        </data>
    </block>
</parameter>
```
