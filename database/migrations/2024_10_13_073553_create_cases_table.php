<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();  // Primary key

            // Vendor Fields
            $table->string('name');
            $table->integer('age');
            $table->string('member_id')->nullable();
            $table->string('corp')->nullable();
            $table->string('tpa')->nullable();
            $table->string('relation')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('doa')->nullable();  // Date of Admission
            $table->time('doa_time')->nullable();
            $table->date('dod')->nullable();  // Date of Discharge
            $table->time('dod_time')->nullable();
            $table->string('aadhar_attachment')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('cancelled_cheque')->nullable();
            $table->string('policy')->nullable();

            // SuperAdmin Fields
            $table->decimal('sum_insured', 15, 2)->nullable();
            $table->string('bill_range')->nullable();
            $table->string('past_hospital')->nullable();
            $table->string('past_diagnosis')->nullable();
            $table->boolean('forward_status')->default(false);
            $table->string('tpa_allot_after_claim_no_received')->nullable();

            // Sales Team Fields
            $table->string('hospital')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('doctor_assigned')->nullable();

            // Doctor Team Fields
            $table->string('icp_attachment')->nullable();
            $table->string('opd_attachment')->nullable();

            // Additional Attachments
            $table->boolean('medicine_vitals_attached')->default(false);
            $table->string('medicine_detail')->nullable();
            $table->string('bill_attachment_1')->nullable();
            $table->string('bill_attachment_2')->nullable();
            $table->string('discharge_summary_attachment')->nullable();

            // Logistics and Dispatch
            $table->string('ipd_no_entry')->nullable();
            $table->boolean('check_box')->default(false);
            $table->string('pre_courier_no')->nullable();
            $table->date('pre_courier_date')->nullable();
            $table->string('pre_dispatch_pdf_attachment')->nullable();
            $table->string('post_courier_no')->nullable();
            $table->date('post_courier_date')->nullable();
            $table->string('post_dispatch_pdf_attachment')->nullable();

            // Claim and Status Tracking
            $table->string('claim_no')->nullable();
            $table->string('patient_details_form')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('approved_amt', 15, 2)->nullable();
            $table->text('query_reply')->nullable();
            $table->text('forward_remark')->nullable();
            $table->enum('patient_claim_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_section', ['draft', 'submitted', 'processed'])->default('draft');

            // Flags and Other Fields
            $table->text('vendor_query_section')->nullable();
            $table->boolean('wallet')->default(false);
            $table->string('department')->nullable();
            $table->boolean('is_priority')->default(false);
            $table->boolean('is_main_bill')->default(false);
            $table->boolean('is_post_1')->default(false);
            $table->boolean('is_post_2')->default(false);

            // Timestamps
            $table->timestamps();  // created_at and updated_at

            // Soft Deletes (if needed)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
