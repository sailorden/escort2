<?phpclass m130614_094634_create_agency_table extends CDbMigration{	public function up()	{        $this->createTable('agency', array(            'a_id'           => 'pk',            'a_name'         => 'string NOT NULL',            'a_description'  => 'text',            'a_skype'        => 'string',            'a_cell_phone'   => 'string',            'a_email'        => 'string',			'a_country_code' => 'string',			'a_city'         => 'string',			'a_active'       => 'boolean',        ));	}	public function down()	{        $this->dropTable('agency');	}}