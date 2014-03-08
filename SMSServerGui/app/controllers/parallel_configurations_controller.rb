class ParallelConfigurationsController < ApplicationController
  # GET /users
  # GET /users.xml
  def index
    @parallel_configurations = ParallelConfiguration.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @parallel_configurations }
    end
  end

  # GET /users/1
  # GET /users/1.xml
  def show
    @parallel_management = ParallelManagement.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @parallel_configuration }
    end
  end

  # GET /users/new
  # GET /users/new.xml
  def new
    @parallel_configuration = ParallelConfiguration.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @parallel_configuration }
    end
  end

  # GET /users/1/edit
  def edit
    @parallel_configuration = ParallelConfiguration.find(params[:id])
  end

  # POST /users
  # POST /users.xml
  def create
    @parallel_configuration = ParallelConfiguration.new(params[:user])

    respond_to do |format|
      if @parallel_configuration.save
        flash[:notice] = 'Parallel Configuration was successfully created.'
        format.html { redirect_to(@parallel_configuration) }
        format.xml  { render :xml => @parallel_configuration, :status => :created, :location => @parallel_configuration }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @parallel_configuration.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /users/1
  # PUT /users/1.xml
  def update
    @parallel_configuration = ParallelConfiguration.find(params[:id])

    respond_to do |format|
      if @parallel_configuration.update_attributes(params[:user])
        flash[:notice] = 'User was successfully updated.'
        format.html { redirect_to(@parallel_configuration) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @parallel_configuration.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /users/1
  # DELETE /users/1.xml
  def destroy
    @parallel_configuration = ParallelConfiguration.find(params[:id])
    @parallel_configuration.destroy

    respond_to do |format|
      format.html { redirect_to(parallel_management_url) }
      format.xml  { head :ok }
    end
  end
end
