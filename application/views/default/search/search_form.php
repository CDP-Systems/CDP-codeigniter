<?php

echo form_open('search/construct');
echo '' . form_input('search');
echo form_submit('submit', 'Submit');
echo form_close();
